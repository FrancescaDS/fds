<?php

/**
 * Fds_Superbundle
 * Fds - fdallserra 2018
 * NOT USED
 * Was called by Frontend/events.xml to hide blocks
 * Didn't work
 */

namespace Fds\Superbundle\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;


class HideBlocks implements ObserverInterface
{

    /**
     * @var \Magento\Framework\App\ActionFlag
     */
    protected $_actionFlag;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @var \Magento\Framework\App\Response\RedirectInterface
     */
    protected $redirect;


    private $_pageConfig;


    /**
     * @param \Magento\Framework\App\ActionFlag $actionFlag
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     */
    public function __construct(
        \Magento\Framework\App\ActionFlag $actionFlag,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\View\Page\Config $pageConfig
    ) {
        $this->_actionFlag = $actionFlag;
        $this->messageManager = $messageManager;
       // $this->redirect = $redirect;
        $this->_pageConfig = $pageConfig;
    }

    /**
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Framework\App\Action\Action $controller */
        $full_action_name = $observer->getFullActionName();
        $layout = $observer->getEvent()->getLayout();

        return $this;
    }

}

