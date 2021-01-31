<?php


namespace Mastering\SampleModule\Controller\adminhtml\Item;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Mastering\SampleModule\Model\ItemFactory;
use Magento\Backend\App\Action\Context;

class Save extends Action
{
    private $itemFactory;

    public function __construct(
        Context $context,
        ItemFactory $itemFactory
    )
    {
        $this->itemFactory = $itemFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $this->itemFactory->create()
            ->setData($this->getRequest()->getPostValue()['general'])
            ->save();
        return $this->resultRedirectFactory->create()->setPath('mastering/index/index');
    }
}
