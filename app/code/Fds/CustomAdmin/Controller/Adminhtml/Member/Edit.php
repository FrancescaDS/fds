<?php


namespace Fds\CustomAdmin\Controller\Adminhtml\Member;

use Fds\Database\Model\AffiliateMember;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;

class Edit extends Action
{
    protected $pageFactory;
    protected $affiliateMember;
    protected $registry;

    public function __construct(
        AffiliateMember $affiliateMember,
        PageFactory $pageFactory,
        Registry $registry,
        Action\Context $context)
    {
        $this->pageFactory = $pageFactory;
        $this->affiliateMember = $affiliateMember;
        $this->registry = $registry;
        parent::__construct($context);
    }

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed("Fds_CustomAdmin::parent");
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam("id");
        $model = $this->affiliateMember;
        if ($id){
            $model->load($id);
            if (!$model->getId()){
                $this->messageManager->addErrorMessage(__('This member does not exist'));
                $result = $this->resultRedirectFactory->create();
                return $result->setPath('affiliate/member/index');
            }
        }
        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)){
            $model->setData($data);
        }
        $this->registry->register("member", $model);
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->pageFactory->create();
        $resultPage->addBreadcrumb($id ? __("Edit Member"): __("Add a New Member"));

        if ($id){
            $resultPage->getConfig()->getTitle()->prepend('Edit');
        } else {
            $resultPage->getConfig()->getTitle()->prepend('Add');
        }

        return $resultPage;
    }
}
