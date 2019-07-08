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

namespace Mageplaza\CronSchedule\Controller\Adminhtml\Log;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\LocalizedException;
use Mageplaza\CronSchedule\Controller\Adminhtml\AbstractLog;
use Mageplaza\CronSchedule\Model\ResourceModel\Schedule\Collection;

/**
 * Class MassDelete
 * @package Mageplaza\CronSchedule\Controller\Adminhtml\Log
 */
class MassDelete extends AbstractLog
{
    /**
     * @return ResponseInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        /** @var Collection $collection */
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        $count = $this->deleteSchedule($collection);

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $count));

        return $this->_redirect('*/*/');
    }
}
