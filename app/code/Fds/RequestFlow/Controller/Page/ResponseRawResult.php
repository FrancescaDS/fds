<?php


namespace Fds\RequestFlow\Controller\Page;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Raw;


// http://fds.local/noroutefound/page/responserawresult

class ResponseRawResult extends Action
{
    protected $raw;

    public function __construct(Context $context, Raw $raw)
    {
        $this->raw = $raw;
        parent::__construct($context);
    }

    public function execute()
    {
        //ritorna una stringa
        $result = $this->raw->setContents('Hello world');
        return $result;
    }


}
