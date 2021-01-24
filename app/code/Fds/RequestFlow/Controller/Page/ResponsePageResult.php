<?php


namespace Fds\RequestFlow\Controller\Page;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;


// http://fds.local/noroutefound/page/responsepageresult

class ResponsePageResult extends Action
{
    protected $pageFactory;

    public function __construct(Context $context, PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        //Magento default frontend
        return $this->pageFactory->create();
    }


}
