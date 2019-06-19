<?php
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

namespace Mageplaza\CronSchedule\Test\Unit\Block\Checkout;

use Magento\Backend\Block\Template\Context;
use Magento\Cron\Model\Schedule;
use Magento\Framework\DB\Select;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Mageplaza\CronSchedule\Block\Adminhtml\Timetable;
use Mageplaza\CronSchedule\Helper\Data;
use Mageplaza\CronSchedule\Model\ResourceModel\Schedule\Grid\Collection;
use Mageplaza\CronSchedule\Model\ResourceModel\Schedule\Grid\CollectionFactory;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

/**
 * Class TimetableTest
 * @package Mageplaza\CronSchedule\Test\Unit\Block\Checkout
 */
class TimetableTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Context|PHPUnit_Framework_MockObject_MockObject
     */
    private $context;

    /**
     * @var Data|PHPUnit_Framework_MockObject_MockObject
     */
    private $helper;

    /**
     * @var DateTime|PHPUnit_Framework_MockObject_MockObject
     */
    private $datetime;

    /**
     * @var TimezoneInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $_localeDate;

    /**
     * @var CollectionFactory|PHPUnit_Framework_MockObject_MockObject
     */
    private $collectionFactory;

    /**
     * @var Timetable
     */
    private $object;

    protected function setUp()
    {
        $this->context           = $this->getMockBuilder(Context::class)->disableOriginalConstructor()->getMock();
        $this->helper            = $this->getMockBuilder(Data::class)->disableOriginalConstructor()->getMock();
        $this->datetime          = $this->getMockBuilder(DateTime::class)->disableOriginalConstructor()->getMock();
        $this->collectionFactory = $this->getMockBuilder(CollectionFactory::class)
            ->setMethods(['create'])
            ->disableOriginalConstructor()->getMock();

        $this->_localeDate = $this->getMockBuilder(TimezoneInterface::class)->getMock();
        $this->context->method('getLocaleDate')->willReturn($this->_localeDate);

        $this->object = new Timetable(
            $this->context,
            $this->helper,
            $this->datetime,
            $this->collectionFactory
        );
    }

    public function testGetCronData()
    {
        $data  = [];
        $count = 0;

        $schedules = $this->getMockBuilder(Collection::class)->disableOriginalConstructor()->getMock();
        $this->collectionFactory->method('create')->willReturn($schedules);

        $select = $this->getMockBuilder(Select::class)->disableOriginalConstructor()->getMock();
        $schedules->method('getSelect')->willReturn($select);
        $select->expects($this->once())->method('order')->with('job_code')->willReturnSelf();

        /** @var Schedule|PHPUnit_Framework_MockObject_MockObject $schedule */
        $schedule = $this->getMockBuilder(Schedule::class)
            ->setMethods([
                'getId',
                'getStatus',
                'getCreatedAt',
                'getScheduledAt',
                'getExecutedAt',
                'getFinishedAt',
                'getJobCode'
            ])
            ->disableOriginalConstructor()->getMock();
        $schedules->method('getItems')->willReturn([$schedule]);

        $id      = '1';
        $status  = 'pending';
        $date    = '2019-06-14 14:23:00';
        $jobCode = 'code';

        $schedule->method('getId')->willReturn($id);
        $schedule->method('getStatus')->willReturn($status);
        $schedule->method('getCreatedAt')->willReturn($date);
        $schedule->method('getScheduledAt')->willReturn($date);
        $schedule->method('getJobCode')->willReturn($jobCode);

        $this->_localeDate->method('formatDateTime')->willReturn($date);

        $datetimeCount = 0;
        $this->datetime->expects($this->at($datetimeCount++))->method('date')->with('Y', $date)->willReturn('2019');
        $this->datetime->expects($this->at($datetimeCount++))->method('date')->with('m', $date)->willReturn('6');
        $this->datetime->expects($this->at($datetimeCount++))->method('date')
            ->with('d,H,i,s', $date)->willReturn('14,14,23,00');

        $this->datetime->expects($this->at($datetimeCount++))->method('date')->with('Y', $date)->willReturn('2019');
        $this->datetime->expects($this->at($datetimeCount++))->method('date')->with('m', $date)->willReturn('6');
        $this->datetime->expects($this->at($datetimeCount))->method('date')
            ->with('d,H,i,s', $date)->willReturn('14,14,23,00');

        $data[] = [
            'start'   => 'new Date(2019,5,14,14,23,00)',
            'end'     => 'new Date(2019,5,14,14,23,00)',
            'group'   => $jobCode,
            'class'   => $count . ' ' . $status,
            'tooltip' => $this->getToolTip($id, $jobCode, $date, $status)
        ];

        $rows = [];
        foreach ($data as $datum) {
            $rows[] = $this->getRow($datum);
        }

        $this->assertEquals([$data, $rows], $this->object->getCronJobData());
    }

    /**
     * @param string $id
     * @param string $code
     * @param string $date
     * @param string $status
     *
     * @return string
     */
    private function getToolTip($id, $code, $date, $status)
    {
        $tooltip = '<table>';

        $tooltip .= sprintf('<tr><th colspan="2" style="text-align: center">%s</th></tr>', $code);
        $tooltip .= sprintf('<tr><th>%s</th><td>%s</td></tr>', __('ID'), $id);

        $statusHtml = sprintf('<span class="tooltip-severity %s">%s</span>', $status, $status);
        $tooltip    .= sprintf('<tr><th>%s</th><td>%s</td></tr>', __('Status'), $statusHtml);

        $tooltip .= sprintf('<tr><th>%s</th><td>%s</td></tr>', __('Created Date'), $date);
        $tooltip .= sprintf('<tr><th>%s</th><td>%s</td></tr>', __('Schedule Date'), $date);

        $tooltip .= '</table>';

        return $tooltip;
    }

    /**
     * @param array $row
     *
     * @return array
     */
    private function getRow($row)
    {
        return [$row['start'], $row['end'], $row['group'], $row['class'], ''];
    }
}
