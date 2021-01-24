<?php


namespace Fds\RequestFlow\Controller\Page;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ResponseInterface;

class CustomNoRoute extends Action
{

    //http://fds.local/noroutefound/page/CustomNoRoute
    public function execute()
    {
        echo "This is our custom 404 page";
    }
}
