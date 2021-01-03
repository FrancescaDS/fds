<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Controller\Adminhtml\Question;

use Fds\Yourproduct\Controller\Adminhtml\Question;

class NewAction extends Question
{
    public function execute()
    {
        $this->_forward('edit');
    }
}
