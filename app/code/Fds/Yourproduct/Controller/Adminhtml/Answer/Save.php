<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Controller\Adminhtml\Answer;

use Fds\Yourproduct\Controller\Adminhtml\Answer;
use Magento\Framework\Exception\LocalizedException;

class Save extends Answer
{

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $model = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Magento\Eav\Model\Attribute::class);

            $id = $this->getRequest()->getParam('attribute_id');

            $frontend_label = trim($data["frontend_label"]);

            if ($id) {
                $model->load($id);
                $model->setData('frontend_label',$frontend_label);
                $model->save();
            } else{
                $model = $this->addAnswer($frontend_label, $model);
            }

            try {
                $modelUrl = \Magento\Framework\App\ObjectManager::getInstance()
                    ->get(\Magento\Eav\Model\Attribute::class);
                if ($id) {
                    $modelURL = $modelUrl->getCollection()
                        ->addFieldToFilter('attribute_id', ['neq' => $id]);
                    $idToAdd = $id;
                } else {
                    $modelURL = $modelUrl->getCollection();
                    $getLastId = $modelURL;
                    $getLastIdData = $getLastId->getLastItem();
                    $lastId = $getLastIdData->getId();
                    $idToAdd = $lastId + 1;
                }

                $attributeId = $model->getId();

                $this->saveAdditionalLabels($model, $data);

                $this->saveProducts($model, $data);

                $this->messageManager
                    ->addSuccess(__('The question has been saved.'));
                $this->_objectManager
                    ->get('Magento\Backend\Model\Session')
                    ->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect(
                        '*/*/edit',
                        ['attribute_id' => $attributeId, '_current' => true]
                    );
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException(
                    $e,
                    __($e->getMessage())
                );
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect(
                '*/*/edit',
                [
                    'attribute_id' => $this->getRequest()
                        ->getParam('attribute_id')
                ]
            );
            return;
        }
        $this->_redirect('*/*/');
    }

    public function saveAdditionalLabels($model, $post){
        $attributeId = $model->getId();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->create("\Magento\Store\Model\StoreManagerInterface");
        $stores = $storeManager->getStores(true, false);
        foreach ($stores as $store) {
            $storeId = $store->getId();
            $key = "answer_" . $storeId;
            $currentdata = $model->getStoreLabels();

            $additionalLabel = "";

            if (array_key_exists($key, $post)) {
                $additionalLabel = trim($post[$key]);
            }

            $currentdata[$storeId] = $additionalLabel;
            $model->setData('store_labels',$currentdata);
            $model->save();
        }
    }

    public function saveProducts($model, $post)
    {
        $attributeId = $model->getId();

        if (isset($post['relatedproducts'])){
            $relatedanswers = $post['relatedproducts'];
            $newRelatedIds = explode('&', $relatedanswers);

            $code = $model->getAttributeCode();

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $oldCollection = $objectManager
                ->create('Magento\Catalog\Model\ResourceModel\Product\Collection')
                ->addAttributeToSelect('*')
                ->addFieldToFilter($code, 1);

            $oldRelatedIds = array();

            $delete = array();
            $insert = array();

            foreach ($oldCollection as $oldProductRelated){
                $old = $oldProductRelated->getId();
                $oldRelatedIds[] = $old;
                if (!(in_array($old, $newRelatedIds))){
                    $delete[] = $old;
                }
            }

            foreach ($newRelatedIds as $new){
                if (!(in_array($new, $oldRelatedIds))){
                    $insert[] = $new;
                }
            }

            if (count($delete) > 0 or count($insert) > 0){
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $productActionObject = $objectManager->create('Magento\Catalog\Model\Product\Action');

                if (count($delete) > 0) {
                    $productActionObject->updateAttributes($delete, array($code => 0), 0);
                }

                if (count($insert) > 0) {
                    $productActionObject->updateAttributes($insert, array($code => 1), 0);
                }
            }
        }
    }


    public function addAnswer($label, $model)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $eavAttribute = $objectManager->create("Magento\Eav\Model\ResourceModel\Entity\Attribute");
        $code = strtolower($label);
        $code = str_replace(' ', '-', $code);
        $code = preg_replace('/[^a-zA-Z0-9\s]/', '', strip_tags(html_entity_decode($code)));
        $code = substr($code, 0, 15);
        $code = 'fdsyour_' . $code;

        for ($i = 1; $i <= 20; $i++) {
            if($eavAttribute->getIdByCode('catalog_product', $code)) {
                $code = $code . $i;
            }else{
                break;
            }
        }

        $eavSetupFactory = $objectManager->create("Magento\Eav\Setup\EavSetupFactory");
        $eavSetup = $eavSetupFactory->create();

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            $code,
            [
                'group' => 'Fds Yourproduct',
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => $label,
                'input' => 'boolean',
                'class' => '',
                'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => '0',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => true,
                'unique' => false,
                'apply_to' => 'simple'
            ]
        );

        $attributeId = $eavAttribute->getIdByCode('catalog_product', $code);

        $model->load($attributeId);

        return $model;
    }


}
