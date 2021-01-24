<?php


namespace Fds\RequestFlow\Controller\Page;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\ForwardFactory;


// http://fds.local/noroutefound/page/responseforwardresult

class ResponseForwardResult extends Action
{
    protected $forwardFactory;

    public function __construct(Context $context, ForwardFactory $forwardFactory)
    {
        $this->forwardFactory = $forwardFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        //redirect senza cambiare URL
        //(Internal redirect)
        //fa vedere la pagina creata in CustomNoRouteHandler.php per il 404
        //http://fds.local/noroutefound/page/customnoroute
        $result = $this->forwardFactory->create();
        $result->setModule('noroutefound')->setController('page')->forward('customnoroute');
        return $result;
    }


}
