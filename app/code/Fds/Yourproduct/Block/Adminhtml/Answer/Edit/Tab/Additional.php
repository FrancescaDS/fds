<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Block\Adminhtml\Answer\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store;
use Magento\Store\Model\StoreFactory;
use Fds\Yourproduct\Model\AnswerFactory;

class Additional extends Generic implements TabInterface
{
    protected $_systemStore;
    protected $_storeFactory;
    protected $_answerFactory;

    public function __construct(
        Context $context,
        Store $systemStore,
        Registry $registry,
        FormFactory $formFactory,
        StoreFactory $storeFactory,
        AnswerFactory $answerFactory,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;

        $this->_storeFactory = $storeFactory;
        $this->_answerFactory = $answerFactory;

        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $form = $this->_formFactory
            ->create(['data' => ['html_id_prefix' => 'page_additional_']]);

        $model = $this->_coreRegistry->registry('answer_answer');

        $isElementDisabled = false;

        $fieldset = $form->addFieldset(
            'Additional_fieldset',
            [
                'legend' => __('Manage Answers'),
                'class' => 'fieldset-wide',
                'disabled' => $isElementDisabled
            ]
        );

        $modelAnswer = $this->_answerFactory->create();

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->create("\Magento\Store\Model\StoreManagerInterface");
        $stores = $storeManager->getStores(true, false);
        foreach ($stores as $store) {
            $storeId = $store->getId();
            $storeName = $store->getName();
            if ($storeId <> 0){
                $attributeId = $model->getAttributeId();
                if ($attributeId){
                    $additionalLabel = $this->getAdditionalLabel($model, $storeId);
                } else {
                    $additionalLabel = "";
                }

                $fieldset->addField(
                    'answer_' . $storeId,
                    'text',
                    [
                        'name' => 'answer_' . $storeId,
                        'label' => $storeName,
                        'title' => $storeName,
                        'value' => $additionalLabel
                    ]
                );
            }
        }

        $this->_eventManager->
        dispatch(
            'adminhtml_answer_edit_tab_additional_prepare_form',
            ['form' => $form]
        );

        $this->setForm($form);

        return parent::_prepareForm();
    }


    public function getAdditionalLabel($model, $storeId){
        $label = "";
        $currentdata = $model->getStoreLabels();
        if (array_key_exists($storeId, $currentdata)) {
            $label = $currentdata[$storeId];
        }
        return $label;
    }


    /**
     * @return mixed
     */
    public function getTabLabel()
    {
        return __('Manage Labels');
    }

    /**
     * @return mixed
     */
    public function getTabTitle()
    {
        return __('Manage Labels');
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
