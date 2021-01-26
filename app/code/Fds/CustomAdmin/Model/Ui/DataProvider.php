<?php


namespace Fds\CustomAdmin\Model\Ui;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Fds\Database\Model\ResourceModel\AffiliateMember\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    protected $loadData;

    public function __construct(
        CollectionFactory $collectionFactory,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = [])
    {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadData)){
            return $this->loadData;
        }

        $items = $this->collection->getItems();
        $this->loadData = array();
        foreach ($items as $member){
            $this->loadData[$member->getId()]['member'] = $member->getData();
        }

        return $this->loadData;
    }
}
