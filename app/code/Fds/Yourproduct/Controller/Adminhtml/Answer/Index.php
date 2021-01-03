<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Controller\Adminhtml\Answer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $_resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Fds_Yourproduct::answer');
        $resultPage->addBreadcrumb(
            __('CMS'),
            __('CMS')
        );
        $resultPage->addBreadcrumb(
            __('Manage Answer'),
            __('Manage Answers')
        );
        $resultPage->getConfig()
            ->getTitle()->prepend(__('Manage Answers'));

        return $resultPage;

    }


}
