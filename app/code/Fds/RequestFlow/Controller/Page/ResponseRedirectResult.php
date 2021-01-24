<?php


namespace Fds\RequestFlow\Controller\Page;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\RedirectFactory;


// http://fds.local/noroutefound/page/responseredirectresult

class ResponseRedirectResult extends Action
{
    protected $redirectFactory;

    public function __construct(Context $context, RedirectFactory $redirectFactory)
    {
        $this->redirectFactory = $redirectFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        //Proper Redirect con cambio di URL
        $result = $this->redirectFactory->create();
        $result->setPath('noroutefound/page/customnoroute');
        return $result;
    }


}
