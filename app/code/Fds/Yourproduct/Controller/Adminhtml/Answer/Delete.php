<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Controller\Adminhtml\Answer;

use Fds\Yourproduct\Controller\Adminhtml\Answer;

class Delete extends Answer
{
    /**
     * @return $this
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('attribute_id');
        $resultRedirect = $this->resultRedirectFactory->create();

        $model = \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Magento\Eav\Model\Attribute::class)->load($id);

        if ($id && $model->getAttributeId()) {
            try {
                $code = $model->getAttributeCode();
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $eavSetupFactory = $objectManager->create("Magento\Eav\Setup\EavSetupFactory");
                $eavSetup = $eavSetupFactory->create();
                $entityTypeId = 4; // 4 is catalog_product
                $eavSetup->removeAttribute($entityTypeId, $code);

                $this->messageManager
                    ->addSuccess(
                        __('The answer has been deleted.')
                    );
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager
                    ->addError($e->getMessage());
                return $resultRedirect
                    ->setPath(
                        '*/*/edit',
                        ['attribute_id' => $id]
                    );
            }
        }
        $this->messageManager->addError(
            __('We can\'t find an answer to delete.')
        );
        return $resultRedirect->setPath('*/*/');
    }
}
