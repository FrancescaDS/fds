<?php


namespace Fds\HelloWorld\Controller\Test;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;


//http://fds.local/helloworld

class Page extends Action
{

    protected $pageFactory;

    public function __construct(Context $context,
                PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {

        //chiama questo frontname(URL) http://fds.local/helloworld/test/page
        //e' una pagina all'interno di Magento
        $this->pageFactory->create();
    }
}
