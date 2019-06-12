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

namespace Mageplaza\CronSchedule\Helper;

use Magento\Framework\App\Area;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\ObjectManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Mageplaza\Core\Helper\AbstractData;

/**
 * Class Email
 * @package Mageplaza\CronSchedule\Helper
 */
class Email extends AbstractData
{
    const CONFIG_MODULE_PATH = 'mpcronschedule';

    /**
     * @var TransportBuilder
     */
    private $transportBuilder;

    /**
     * Email constructor.
     *
     * @param Context $context
     * @param ObjectManagerInterface $objectManager
     * @param StoreManagerInterface $storeManager
     * @param TransportBuilder $transportBuilder
     */
    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        StoreManagerInterface $storeManager,
        TransportBuilder $transportBuilder
    ) {
        $this->transportBuilder = $transportBuilder;

        parent::__construct($context, $objectManager, $storeManager);
    }

    /**
     * @param null $storeId
     *
     * @return bool
     */
    public function isEmailNotification($storeId = null)
    {
        return (bool) $this->getConfigGeneral('email_notification', $storeId);
    }

    /**
     * @param null $storeId
     *
     * @return string
     */
    public function getSendFrom($storeId = null)
    {
        return $this->getConfigGeneral('send_from', $storeId);
    }

    /**
     * @param null $storeId
     *
     * @return array
     */
    public function getSendTo($storeId = null)
    {
        return array_map('trim', explode(',', $this->getConfigGeneral('send_to', $storeId)));
    }

    /**
     * @param null $storeId
     *
     * @return string
     */
    public function getTemplate($storeId = null)
    {
        return $this->getConfigGeneral('email_template', $storeId);
    }

    /**
     * @param null $storeId
     *
     * @return string
     */
    public function getSchedule($storeId = null)
    {
        return $this->getConfigGeneral('schedule', $storeId);
    }

    /**
     * @param array $templateVars
     */
    public function sendEmail($templateVars = [])
    {
        $transportBuilder = $this->transportBuilder
            ->setTemplateIdentifier($this->getTemplate())
            ->setTemplateOptions(['area' => Area::AREA_FRONTEND, 'store' => 0])
            ->setTemplateVars($templateVars)
            ->setFrom($this->getSendFrom());

        foreach ($this->getSendTo() as $email) {
            $transportBuilder->addTo($email);
        }

        try {
            $transportBuilder->getTransport()->sendMessage();
        } catch (MailException $e) {
            $this->_logger->critical($e->getMessage());
        }
    }
}
