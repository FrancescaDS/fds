<?php

/**
 * Fds_Superbundle
 * Fds - fdallserra 2018
 * NOT USED
 */

namespace Fds\Superbundle\Controller\Index;

class Config extends \Magento\Framework\App\Action\Action
{

    protected $helperData;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Fds\Superbundle\Helper\Data $helperData
        )
    {
        $this->helperData = $helperData;
        return parent::__construct($context);
    }

    public function execute()
    {
        // TODO: Implement execute() method.

        echo $this->helperData->getGeneralConfig('enable');
        echo $this->helperData->getGeneralConfig('display_text');
        exit();
    }
}