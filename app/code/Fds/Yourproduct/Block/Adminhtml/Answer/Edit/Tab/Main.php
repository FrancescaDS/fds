<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Block\Adminhtml\Answer\Edit\Tab;

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
        $model = $this->_coreRegistry->registry('answer_answer');
        $isElementDisabled = false;
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('page_');
        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Answer Properties')]
        );
        if ($model->getId()) {
            $fieldset->addField(
                'attribute_id',
                'hidden',
                ['name' => 'attribute_id']
            );
        }

        $fieldset->addField(
            'frontend_label',
            'text',
            [
                'name' => 'frontend_label',
                'label' => __('Frontend label'),
                'title' => __('Frontend label'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'attribute_code',
            'text',
            [
                'name' => 'attribute_code',
                'label' => __('Attribute code'),
                'title' => __('Attribute code'),
                'disabled' => 'disabled'
            ]
        );

        $wysiwygConfig = $this->_wysiwygConfig
            ->getConfig(['tab_id' => $this->getTabId()]);


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
