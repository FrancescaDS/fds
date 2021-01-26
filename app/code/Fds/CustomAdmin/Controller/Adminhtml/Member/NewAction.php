<?php


namespace Fds\CustomAdmin\Controller\Adminhtml\Member;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Backend\Model\View\Result\ForwardFactory;

class NewAction extends Action
{
    protected $forwardFactory;

    public function __construct(
        ForwardFactory $forwardFactory,
        Action\Context $context)
    {
        $this->forwardFactory = $forwardFactory;
        parent::__construct($context);
    }

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed("Fds_CustomAdmin::parent");
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Forward $resultForward */
        $resultForward = $this->forwardFactory->create();
        return $resultForward->forward('edit');
    }
}
