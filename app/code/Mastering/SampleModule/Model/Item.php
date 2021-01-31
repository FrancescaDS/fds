<?php


namespace Mastering\SampleModule\Model;

use Magento\Backend\App\Action;
use Magento\Framework\Model\AbstractModel;

class Item extends AbstractModel
{
    //attacco al model un evento prefix che puo' essere usato come evento in events.xml
    protected $_eventPrefix = 'mastering_sample_item';

    protected function _construct()
    {
        //lo inizializzo con il suo resourceModel
        $this->_init(\Mastering\SampleModule\Model\ResourceModel\Item::class);
    }
}
