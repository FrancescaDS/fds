<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Block\Adminhtml\Question\Edit\Tab;

use Fds\Yourproduct\Model\Status;
use Fds\Yourproduct\Model\Multiselect;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Cms\Model\Wysiwyg\Config;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store;

class Main extends Generic implements TabInterface
{
    protected $_systemStore;
    protected $_wysiwygConfig;
    protected $_status;
    protected $_multiselect;

    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Store $systemStore,
        Config $wysiwygConfig,
        Status $status,
        Multiselect $multiselect,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_status = $status;
        $this->_multiselect = $multiselect;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('question_question');

        $isElementDisabled = false;

        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Question Properties')]
        );
        if ($model->getId()) {
            $fieldset->addField(
                'question_id',
                'hidden',
                ['name' => 'question_id']
            );
        }

        $fieldset->addField(
            'question_order',
            'text',
            [
                'name' => 'question_order',
                'label' => __('Question order'),
                'title' => __('Question order'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'question',
            'text',
            [
                'name' => 'question',
                'label' => __('Question'),
                'title' => __('Question'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );

        $wysiwygConfig = $this->_wysiwygConfig
            ->getConfig(['tab_id' => $this->getTabId()]);

        $fieldset->addField(
            'multi_select',
            'select',
            [
                'label' => __('Multiselect'),
                'title' => __('Multiselect'),
                'name' => 'multi_select',
                'required' => true,
                'options' => $this->_multiselect->getOptionArray(),
                'disabled' => $isElementDisabled
            ]
        );

        if (!$model->getId()) {
            $model->setData('multi_select', $isElementDisabled ? '0' : '1');
        }

        $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'status',
                'required' => true,
                'options' => $this->_status->getOptionArray(),
                'disabled' => $isElementDisabled
            ]
        );

        if (!$model->getId()) {
            $model->setData('status', $isElementDisabled ? '0' : '1');
        }

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * @return mixed
     */
    public function getTabLabel()
    {
        return __('Properties');
    }

    /**
     * @return mixed
     */
    public function getTabTitle()
    {
        return __('Properties');
    }

    /**
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

}
