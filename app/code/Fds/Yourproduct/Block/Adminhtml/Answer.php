<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

class Answer extends Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_answer';
        $this->_blockGroup = 'Fds_Yourproduct';
        $this->_headerText = __('Manage Answer');
        $this->_addButtonLabel = __('Add Answer');
        parent::_construct();
    }
}
