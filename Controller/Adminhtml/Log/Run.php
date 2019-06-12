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

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\LocalizedException;
use Mageplaza\CronSchedule\Model\Command;

/**
 * Class Run
 * @package Mageplaza\CronSchedule\Controller\Adminhtml\Log
 */
class Run extends Action
{
    /**
     * @var Command
     */
    private $command;

    /**
     * Run constructor.
     *
     * @param Context $context
     * @param Command $command
     */
    public function __construct(
        Context $context,
        Command $command
    ) {
        $this->command = $command;

        parent::__construct($context);
    }

    /**
     * @return ResponseInterface
     */
    public function execute()
    {
        try {
            $this->command->run();

            $this->messageManager->addSuccessMessage(__('Command has been run.'));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $this->_redirect('*/*/');
    }
}
