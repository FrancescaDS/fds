<?php


namespace Fds\CustomAdmin\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Index extends Action
{
    private $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig, Context $context)
    {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    //  http://fds.local/system/index/index
    // 'system' e' il valore di frontName contenuto in routes.xml
    public function execute()
    {
        //per prendere valori dall'admin (valori di configuration)

        $result = $this->scopeConfig->getValue('Firstsection/Firstgroup/Firstfield') . "<br>"
            . $this->scopeConfig->getValue('Firstsection/Firstgroup/Secondfield') . "<br>"
            . $this->scopeConfig->getValue('Firstsection/Firstgroup/Fourthfield') . "<br>";

        echo $result;
        print_r($this->scopeConfig->getValue('Firstsection/Firstgroup/Thirdfield'));


    }
}
