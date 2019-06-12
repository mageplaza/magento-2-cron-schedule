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

namespace Mageplaza\CronSchedule\Controller\Adminhtml\Job;

use Magento\Framework\DataObject;
use Magento\Framework\View\Layout;
use Mageplaza\CronSchedule\Controller\Adminhtml\AbstractJob;
use Zend_Validate_Exception;
use Zend_Validate_Regex;

/**
 * Class Validate
 * @package Mageplaza\CronSchedule\Controller\Adminhtml\Job
 */
class Validate extends AbstractJob
{
    /**
     * @return void
     * @throws Zend_Validate_Exception
     */
    public function execute()
    {
        $response = new DataObject();
        $response->setError(false);
        $error = false;

        $name = $this->getRequest()->getParam('code');

        $validator = new Zend_Validate_Regex(['pattern' => '/^[a-z][a-z_0-9]{0,30}$/']);
        if (!$validator->isValid($name)) {
            $this->messageManager->addErrorMessage(__(
                'Cron job code "%1" is invalid. Please use only letters (a-z), numbers (0-9) or underscore(_) in this field, first character should be a letter.',
                $name
            ));
            $error = true;
        }

        $orgName = $this->getRequest()->getParam('org_name');
        $jobs    = $this->helper->getJobs();

        if ($name !== $orgName && isset($jobs[$name])) {
            $this->messageManager->addErrorMessage(__('An cron job with this code already exists.'));
            $error = true;
        }

        if ($error) {
            /** @var Layout $layout */
            $layout = $this->_view->getLayout();
            $layout->initMessages();
            $response->setError(true);
            $response->setHtmlMessage($layout->getMessagesBlock()->getGroupedHtml());
        }

        $this->getResponse()->setBody($response->toJson());
    }
}
