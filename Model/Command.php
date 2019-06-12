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

namespace Mageplaza\CronSchedule\Model;

use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Process\PhpExecutableFinder;
use Magento\Framework\Process\PhpExecutableFinderFactory;
use Magento\Framework\ShellInterface;

/**
 * Class Command
 * @package Mageplaza\CronSchedule\Model
 */
class Command
{
    /**
     * @var ShellInterface
     */
    private $shell;

    /**
     * @var PhpExecutableFinder
     */
    private $phpExecutableFinder;

    /**
     * Command constructor.
     *
     * @param ShellInterface $shell
     * @param PhpExecutableFinderFactory $phpExecutableFinderFactory
     */
    public function __construct(
        ShellInterface $shell,
        PhpExecutableFinderFactory $phpExecutableFinderFactory
    ) {
        $this->shell               = $shell;
        $this->phpExecutableFinder = $phpExecutableFinderFactory->create();
    }

    /**
     * @param string $command
     *
     * @throws LocalizedException
     */
    public function run($command = 'cron:run')
    {
        $phpPath = $this->phpExecutableFinder->find() ?: 'php';

        $this->shell->execute('%s %s %s', [$phpPath, BP . '/bin/magento', $command]);
    }
}
