<?php


namespace Mastering\SampleModule\Block;

use Magento\Framework\View\Element\Template;
use Mastering\SampleModule\Model\ResourceModel\Item\Collection;
use Mastering\SampleModule\Model\ResourceModel\Item\CollectionFactory; //aggiungendo 'Factory' si autocrea

class Classforblock extends Template
{
    private $collectionFactory; //creo una property della classe

    public function __construct(
        CollectionFactory $collectionFactory, //innietto la factory della collection
        Template\Context $context,
        array $data = [])
    {
        $this->collectionFactory = $collectionFactory; // assegno il valore alla property
        parent::__construct($context, $data);
    }

    //method che retorna items per il template
    //ritornera' instances of models
    /**
     * @return Mastering\SampleModule\Model\Item[]
     */
    public function getItems(){
        return $this->collectionFactory->create()->getItems();

    }
}
