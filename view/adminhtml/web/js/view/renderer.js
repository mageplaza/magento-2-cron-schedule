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
    'Mageplaza_CronSchedule/js/lib/timeline-min',
    'https://www.google.com/jsapi'
], function ($, _) {
    "use strict";

    var hour       = 1000 * 60 * 60,
        day        = hour * 24,
        week       = day * 7,
        month      = day * 30,
        orgOptions = {
            animate: false,
            animateZoom: false,
            axisOnTop: true,
            eventMarginAxis: 5,
            selectable: false,
            stackEvents: false,
            groupMinHeight: 35,
            showCurrentTime: false,
            zoomMin: 1000,
            zoomMax: 1000 * 60 * 60 * 24 * 365 * 10,
            min: new Date(-2208985200000),
            max: new Date(32503683600000)
        };

    $.widget('mageplaza.cron_schedule', {
        _create: function () {
            var self    = this,
                tooltip = $('#tooltip-block');

            google.load('visualization', '1', {
                'callback': function () {
                    self.drawVisualization();
                }
            });

            $(document).on('mouseover', '.timeline-event', function (event) {
                var classAttr = $(this).attr('class').split(' ');

                if (classAttr.length <= 4) {
                    return;
                }

                tooltip.html(self.options.data[classAttr[4]].tooltip);
                tooltip.show();
                tooltip.css({
                    top: (event.pageY + 5) + 'px',
                    right: (window.innerWidth - event.pageX - 5) + 'px'
                });
            });

            $(document).on('mouseout', '.timeline-event', function () {
                tooltip.hide();
            });
        },

        drawVisualization: function () {
            var self = this;

            // Create and populate a data table
            var data = new google.visualization.DataTable();

            // Instantiate our timeline object
            var timeline = new links.Timeline(document.getElementById('mpcronschedule'), orgOptions);

            data.addColumn('datetime', 'start');
            data.addColumn('datetime', 'end');
            data.addColumn('string', 'group');
            data.addColumn('string', 'className');
            data.addColumn('string', 'content');

            _.each(this.options.rows, function (row) {
                row[0] = eval.call(null, row[0]);
                row[1] = eval.call(null, row[1]);

                data.addRow(row);
            });

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
                        min: new Date(newDate - day),
                        max: new Date(newDate + hour)
                    };
                case 'week':
                    return {
                        min: new Date(newDate - week),
                        max: new Date(newDate + hour)
                    };
                case 'month':
                    return {
                        min: new Date(newDate - month),
                        max: new Date(newDate + hour)
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
