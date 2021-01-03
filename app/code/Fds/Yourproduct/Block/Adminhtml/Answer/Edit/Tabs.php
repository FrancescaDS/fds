<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Block\Adminhtml\Answer\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('answer_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Answer Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab(
            'related_products_section',
            [
                'label' => __('Related Products'),
                'url' => $this->getUrl(
                    'yourproduct/answer/relatedProducts',
                    ['_current' => true]
                ),
                'class' => 'ajax',
            ]
        );
        return parent::_beforeToHtml();
    }

}
