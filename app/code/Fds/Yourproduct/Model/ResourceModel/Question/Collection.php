<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Model\ResourceModel\Question;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = \Fds\Yourproduct\Model\Question::QUESTION_ID;
    protected function _construct()
    {
        $this->_init(
                'Fds\Yourproduct\Model\Question',
                'Fds\Yourproduct\Model\ResourceModel\Question'
            );
    }

}
