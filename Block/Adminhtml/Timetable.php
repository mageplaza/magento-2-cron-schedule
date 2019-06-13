<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the mageplaza.com license that is
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

namespace Mageplaza\CronSchedule\Block\Adminhtml;

use IntlDateFormatter;
use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Cron\Model\Schedule;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Mageplaza\CronSchedule\Helper\Data;
use Mageplaza\CronSchedule\Model\ResourceModel\Schedule\CollectionFactory;

/**
 * Class Timetable
 * @package Mageplaza\CronSchedule\Block\Adminhtml
 */
class Timetable extends Template
{
    /**
     * @var Data
     */
    private $helper;

    /**
     * @var DateTime
     */
    private $datetime;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * Timetable constructor.
     *
     * @param Context $context
     * @param Data $helper
     * @param DateTime $datetime
     * @param CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $helper,
        DateTime $datetime,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->helper            = $helper;
        $this->datetime          = $datetime;
        $this->collectionFactory = $collectionFactory;

        parent::__construct($context, $data);
    }

    /**
     * @return array
     */
    public function getCronJobData()
    {
        $data  = [];
        $count = 0;

        $schedules = $this->collectionFactory->create();

        $schedules->getSelect()->order('job_code');

        /** @var Schedule $schedule */
        foreach ($schedules as $schedule) {
            $status = $schedule->getStatus();
            $start  = $schedule->getScheduledAt();
            $end    = $start;

            switch ($status) {
                case Schedule::STATUS_RUNNING:
                    $end = $this->helper->getTime();
                    break;
                case Schedule::STATUS_SUCCESS:
                    $start = $schedule->getExecutedAt();
                    $end   = $schedule->getFinishedAt();
                    break;
            }

            $data[] = [
                'start'   => $this->getDate($start),
                'end'     => $this->getDate($end),
                'group'   => $schedule->getJobCode(),
                'class'   => $count . ' ' . $status,
                'tooltip' => $this->getToolTip($schedule, $status)
            ];

            $count++;
        }

        $rows = [];
        foreach ($data as $datum) {
            $rows[] = $this->getRow($datum);
        }

        return [$data, $rows];
    }

    /**
     * @param Schedule $schedule
     * @param string $status
     *
     * @return string
     */
    private function getToolTip($schedule, $status)
    {
        $tooltip = '<table>';

        $tooltip .= sprintf('<tr><th colspan="2" style="text-align: center">%s</th></tr>', $schedule->getJobCode());
        $tooltip .= sprintf('<tr><th>%s</th><td>%s</td></tr>', __('ID'), $schedule->getId());

        $statusHtml = sprintf('<span class="tooltip-severity %s">%s</span>', $status, $status);
        $tooltip    .= sprintf('<tr><th>%s</th><td>%s</td></tr>', __('Status'), $statusHtml);

        if ($message = $schedule->getMessages()) {
            $tooltip .= sprintf('<tr><th>%s</th><td>%s</td></tr>', __('Message'), $this->escapeQuote($message));
        }

        if ($status === Schedule::STATUS_SUCCESS) {
            $time    = strtotime($schedule->getFinishedAt()) - strtotime($schedule->getExecutedAt());
            $tooltip .= sprintf('<tr><th>%s</th><td>%s</td></tr>', __('Total Executed Time'), $time . ' second(s)');
        }

        $tooltip .= sprintf(
            '<tr><th>%s</th><td>%s</td></tr>',
            __('Created Date'),
            $this->formatDate($schedule->getCreatedAt())
        );
        $tooltip .= sprintf(
            '<tr><th>%s</th><td>%s</td></tr>',
            __('Schedule Date'),
            $this->formatDate($schedule->getScheduledAt())
        );

        if ($executedAt = $schedule->getExecutedAt()) {
            $tooltip .= sprintf('<tr><th>%s</th><td>%s</td></tr>', __('Executed Date'), $this->formatDate($executedAt));
        }

        if ($finishedAt = $schedule->getFinishedAt()) {
            $tooltip .= sprintf(
                '<tr><th>%s</th><td>%s</td></tr>',
                __(' Finished Date'),
                $this->formatDate($finishedAt)
            );
        }

        $tooltip .= '</table>';

        return $tooltip;
    }

    /**
     * @param string $date
     *
     * @return string
     */
    public function getDate($date)
    {
        $date = $this->formatDate($date);

        return sprintf(
            'new Date(%d,%d,%s)',
            $this->datetime->date('Y', $date),
            $this->datetime->date('m', $date) - 1,
            $this->datetime->date('d,H,i,s', $date)
        );
    }

    /**
     * @param null $date
     * @param int $format
     * @param bool $showTime
     * @param null $timezone
     *
     * @return string
     */
    public function formatDate($date = null, $format = \IntlDateFormatter::SHORT, $showTime = false, $timezone = null)
    {
        return parent::formatDate($date, IntlDateFormatter::MEDIUM, true, $this->_localeDate->getConfigTimezone());
    }

    /**
     * @param array $row
     *
     * @return array
     */
    public function getRow($row)
    {
        return [$row['start'], $row['end'], $row['group'], $row['class'], ''];
    }

    /**
     * @return string
     */
    public function getTimezone()
    {
        return $this->_localeDate->getConfigTimezone();
    }
}
