<?php


namespace Fds\Database\Model\ResourceModel\AffiliateMember;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Fds\Database\Model\AffiliateMember;
use Fds\Database\Model\ResourceModel\AffiliateMember as AffiliateMemberResource;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init(AffiliateMember::class, AffiliateMemberResource::class);
    }
}
