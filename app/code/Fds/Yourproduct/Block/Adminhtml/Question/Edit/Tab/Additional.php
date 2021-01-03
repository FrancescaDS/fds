<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Block\Adminhtml\Question\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store;
use Magento\Store\Model\StoreFactory;

class Additional extends Generic implements TabInterface
{
    protected $_systemStore;
    protected $_storeFactory;

    public function __construct(
        Context $context,
        Store $systemStore,
        Registry $registry,
        FormFactory $formFactory,
        StoreFactory $storeFactory,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;

        $this->_storeFactory = $storeFactory;

        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {

        $form = $this->_formFactory
            ->create(['data' => ['html_id_prefix' => 'page_additional_']]);

        $model = $this->_coreRegistry->registry('question_question');


        $isElementDisabled = false;

        $fieldset = $form->addFieldset(
            'Additional_fieldset',
            [
                'legend' => __('Manage Questions'),
                'class' => 'fieldset-wide',
                'disabled' => $isElementDisabled
            ]
        );

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->create("\Magento\Store\Model\StoreManagerInterface");
        $stores = $storeManager->getStores(true, false);
        foreach ($stores as $store) {
            $storeId = $store->getId();
            $storeName = $store->getName();

            if ($storeId <> 0){
                if ($model->getId()){
                    $additionalLabel = $model->getQuestionAdditionalLabel($storeId);
                } else {
                    $additionalLabel = "";
                }

                $fieldset->addField(
                    'question_' . $storeId,
                    'text',
                    [
                        'name' => 'question_' . $storeId,
                        'label' => $storeName,
                        'title' => $storeName,
                        'value' => $additionalLabel
                    ]
                );
            }
        }

        $this->_eventManager->
        dispatch(
            'adminhtml_question_edit_tab_additional_prepare_form',
            ['form' => $form]
        );

        //$form->setValues($model->getData());

        $this->setForm($form);

        return parent::_prepareForm();
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
