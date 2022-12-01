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

namespace Mageplaza\CronSchedule\Ui\DataProvider;

use Magento\Framework\Api\Filter;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Mageplaza\CronSchedule\Helper\Data;

/**
 * Class JobProvider
 * @package KiwiCommerce\CronScheduler\Ui\DataProvider
 */
class JobProvider extends AbstractDataProvider
{
    /**
     * @var integer
     */
    protected $size = 20;

    /**
     * @var integer
     */
    protected $offset = 1;

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var string
     */
    protected $sortField = 'name';

    /**
     * @var string
     */
    protected $sortDir = 'asc';

    /**
     * @var Data
     */
    private $helper;

    /**
     * Class constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param Data $helper
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Data $helper,
        array $meta = [],
        array $data = []
    ) {
        $this->helper = $helper;

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @param Filter $filter
     */
    public function addFilter(Filter $filter)
    {
        $this->filters[$filter->getConditionType()] = [
            'field' => $filter->getField(),
            'value' => $filter->getValue()
        ];
    }

    /**
     * @param string $field
     * @param string $direction
     */
    public function addOrder($field, $direction)
    {
        $this->sortField = $field;
        $this->sortDir   = strtolower($direction);
    }

    /**
     * @param int $offset
     * @param int $size
     */
    public function setLimit($offset, $size)
    {
        $this->size   = $size;
        $this->offset = $offset;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $items = $this->helper->getJobs();

        // add filter
        foreach ($this->filters as $type => $filter) {
            $field = $filter['field'];
            $value = str_replace('\\', '', $filter['value']);

            $items = array_filter($items, function ($item) use ($field, $value, $type) {
                switch ($type) {
                    case 'like':
                        return $item[$field] ? stripos($item[$field], substr($value, '1', '-1')) !== false : false;
                    case 'eq':
                        return $item[$field] === $value;
                    case 'in':
                        return in_array($item[$field], array_values($value), true);
                    default:
                        return true;
                }
            });
        }

        // add order
        $sortField = $this->sortField;
        $sortDir   = $this->sortDir;
        usort($items, function ($a, $b) use ($sortField, $sortDir) {
            return $sortDir === 'asc' ? ($a[$sortField] > $b[$sortField] ? 1 : -1) : ($a[$sortField] < $b[$sortField] ? 1 : -1);
        });

        $totalRecords = count($items);

        // set limit
        $items = array_slice($items, ($this->offset - 1) * $this->size, $this->size);

        return compact('totalRecords', 'items');
    }
}
