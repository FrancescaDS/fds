<?php


namespace Fds\CustomAdmin\Controller\Adminhtml\Member;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    private $pageFactory;

    public function __construct(
        PageFactory $pageFactory,
        Action\Context $context)
    {
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }

    //ritona una pagina nel backend di Magento
//http://fds.local/admin_fds/affiliate/member/index
//affiliate viene da routes.xml
//e in menu.xml    action="affiliate/member/index"
// il controlle quindi e' in \Adminhtml\Member e la classe si chiama index
    /**
     * @return ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        return $this->pageFactory->create();
    }
}
