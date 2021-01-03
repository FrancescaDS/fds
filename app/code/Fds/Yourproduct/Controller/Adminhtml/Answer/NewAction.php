<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Controller\Adminhtml\Answer;

use Fds\Yourproduct\Controller\Adminhtml\Answer;

class NewAction extends Answer
{
    /**
     *
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
