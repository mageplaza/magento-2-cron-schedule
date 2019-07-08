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

namespace Mageplaza\CronSchedule\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Mageplaza\CronSchedule\Helper\Data;

/**
 * Class LogActions
 * @package Mageplaza\CronSchedule\Ui\Component\Listing\Column
 */
class LogActions extends Column
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @var Data
     */
    private $helper;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param Data $helper
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        Data $helper,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->helper = $helper;

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        $name = $this->getName();
        $jobs = $this->helper->getJobs();

        if (isset($dataSource['data']['items']) && is_array($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $code = $item['job_code'];

                if (empty($jobs[$code]['is_user'])) {
                    continue;
                }

                $item[$name]['edit'] = [
                    'href'  => $this->urlBuilder->getUrl('mpcronschedule/job/edit', ['name' => $code]),
                    'label' => __('View')
                ];
            }
        }

        return $dataSource;
    }
}
