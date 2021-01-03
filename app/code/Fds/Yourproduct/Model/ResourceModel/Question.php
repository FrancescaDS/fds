<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Question extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('fdsyour_question', 'question_id');
    }
}
