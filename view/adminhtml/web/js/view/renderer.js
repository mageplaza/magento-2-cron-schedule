/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_CronSchedule
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

define([
    'jquery',
    'underscore',
    'Mageplaza_CronSchedule/js/lib/timeline-min'
], function ($, _) {
    "use strict";

    var hour       = 1000 * 60 * 60,
        day        = hour * 24,
        week       = day * 7,
        month      = day * 30,
        offset     = new Date().getTimezoneOffset() * 1000 * 60,
        orgOptions = {
            animate: false,
            animateZoom: false,
            axisOnTop: true,
            eventMarginAxis: 5,
            selectable: false,
            stackEvents: false,
            groupMinHeight: 35,
            zoomMin: 1000,
            zoomMax: 1000 * 60 * 60 * 24 * 365 * 10,
            min: new Date((new Date()).valueOf() - day + offset),
            max: new Date((new Date()).valueOf() + hour + offset)
        };
    // google.load('visualization', '0');

    $.widget('mageplaza.cron_schedule', {
        _create: function () {
            var self = this;

            // Set callback to run when API is loaded
            google.setOnLoadCallback(this.drawVisualization(this));

            var tooltip = $('#tooltip-block');

            $(document).on('mouseover', '.timeline-event', function (event) {
                var classAttr = $(this).attr('class').split(' ');

                if (classAttr.length > 4) {
                    tooltip.show();

                    tooltip.css({
                        top: (event.pageY + 5) + 'px',
                        left: (event.pageX + 5) + 'px'
                    });

                    tooltip.html(self.options.data[classAttr[4]]['tooltip']);
                }
            });

            $(document).on('mouseout', '.timeline-event', function () {
                tooltip.hide();
            });
        },

        drawVisualization: function (self) {
            // Create and populate a data table
            var data = new google.visualization.DataTable();
            data.addColumn('datetime', 'start');
            data.addColumn('datetime', 'end');
            data.addColumn('string', 'group');
            data.addColumn('string', 'className');
            data.addColumn('string', 'content');

            _.each(self.options.rows, function (row) {
                row[0] = eval.call(null, row[0]);
                row[1] = eval.call(null, row[1]);

                data.addRow(row);
            });

            // Instantiate our timeline object
            var timeline = new links.Timeline(document.getElementById('mpcronschedule'), orgOptions);

            timeline.repaintCurrentTime = function () {
                links.Timeline.prototype.repaintCurrentTime.call(this);
                var nowOffset = new Date(new Date().valueOf());

                this.dom.currentTime.title = "Current time: " + nowOffset.toGMTString();
            };

            timeline.setCurrentTime(new Date((new Date()).valueOf() + offset));
            timeline.setData(data);
            timeline.move(0);

            $(document).on('change', '#mpcronschedule-period', function () {
                timeline.setOptions(_.extend(orgOptions, self.getOptions($(this).val())));
                timeline.redraw();
                timeline.move(0);
            });
        },

        getOptions: function (period) {
            var newDate = (new Date()).valueOf();

            switch (period){
                case 'day':
                    return {
                        min: new Date(newDate - day + offset),
                        max: new Date(newDate + hour + offset)
                    };
                case 'week':
                    return {
                        min: new Date(newDate - week + offset),
                        max: new Date(newDate + hour + offset)
                    };
                case 'month':
                    return {
                        min: new Date(newDate - month + offset),
                        max: new Date(newDate + hour + offset)
                    };
                default:
                    return {
                        min: new Date(-2208985200000),
                        max: new Date(32503683600000)
                    };
            }
        }
    });

    return $.mageplaza.cron_schedule;
});
