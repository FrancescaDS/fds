<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

class Question extends Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_question';
        $this->_blockGroup = 'Fds_Yourproduct';
        $this->_headerText = __('Manage Question');
        $this->_addButtonLabel = __('Add Question');
        parent::_construct();
    }
}
