<?php


namespace Fds\RequestFlow\Controller\Page;


use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ActionFactory;

class Router implements \Magento\Framework\App\RouterInterface
{
    protected $actionFactory;

    public function __construct(ActionFactory $actionFactory)
    {
        $this->actionFactory = $actionFactory;
    }


    /**
     * @inheritDoc
     */
    public function match(RequestInterface $request)
    {
        //    path con "-" che risponda a url con "/"
        //     /customer-account-login il sistema lo deve leggere /customer/account/login
        //    /customer-account-login >> questo e' contenuto in getPathInfo
        //elimino il primo slash con il trim
        $path = trim($request->getPathInfo(),'/');
        // lo trasformo in un array
        $paths = explode('-', $path);
        $request->setModuleName($paths[0]);
        $request->setControllerName($paths[1]);
        $request->setActionName($paths[2]);

        return $this->actionFactory->create('Magento\Framework\App\Action\Forward', ['request'=>$request]);

    }
}
