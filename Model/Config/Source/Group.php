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

namespace Mageplaza\CronSchedule\Model\Config\Source;

use Magento\Cron\Model\ConfigInterface;

/**
 * Class Group
 * @package Mageplaza\CronSchedule\Model\Config\Source
 */
class Group extends AbstractSource
{
    /**
     * @var array
     */
    private $options;

    /**
     * @var ConfigInterface
     */
    private $cronConfig;

    /**
     * Group constructor.
     *
     * @param ConfigInterface $cronConfig
     */
    public function __construct(ConfigInterface $cronConfig)
    {
        $this->cronConfig = $cronConfig;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options === null) {
            foreach (array_keys($this->cronConfig->getJobs()) as $group) {
                $this->options[] = ['label' => ucfirst($group), 'value' => $group];
            }
        }

        return $this->options;
    }
}
