<?php


namespace Fds\RequestFlow\Controller\Page;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\JsonFactory;


// http://fds.local/noroutefound/page/responsejsonresult

class ResponseJsonResult extends Action
{
    protected $jsonFactory;

    public function __construct(Context $context, JsonFactory $jsonFactory)
    {
        $this->jsonFactory = $jsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        //JSON format
        return $this->jsonFactory->create()->setData(['key'=>'value', 'key2'=>['one','two','three']]);
    }


}
