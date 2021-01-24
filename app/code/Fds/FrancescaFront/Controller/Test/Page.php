<?php


namespace Fds\FrancescaFront\Controller\Test;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;

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
        //chiama questo frontname(URL) http://fds.local/francesca/test/page
        //francesca lo prende da frontend del file routes
        //e' una pagina all'interno di Magento
        return $this->pageFactory->create();
    }
}
