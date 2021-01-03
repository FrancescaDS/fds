<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Block\Adminhtml\Question\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('question_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Question Information'));
    }

    protected function _beforeToHtml()
    {
       $this->addTab(
            'related_answers_section',
            [
                'label' => __('Related Answers'),
                'url' => $this->getUrl(
                    'yourproduct/question/relatedAnswers',
                    ['_current' => true]
                ),
                'class' => 'ajax',
            ]
        );
        return parent::_beforeToHtml();
    }

}
