<?php


namespace Mastering\SampleModule\Controller\adminhtml\Item;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action;

class NewAction extends Action
{
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
