<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Controller\Adminhtml\Answer;

use Fds\Yourproduct\Controller\Adminhtml\Answer;

class MassDelete extends Answer
{
    /**
     * @return $this
     */
    public function execute()
    {
        $answerIds = $this->getRequest()->getParam('answer');
        if (!is_array($answerIds) || empty($answerIds)) {
            $this->messageManager->addError(__('Please select answer(s).'));
        } else {
            try {
                foreach ($answerIds as $attributeId) {
                    $attribute = \Magento\Framework\App\ObjectManager::getInstance()
                        ->get(\Magento\Eav\Model\Attribute::class)->load($attributeId);
                    $code = $attribute->getAttributeCode();
                    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                    $eavSetupFactory = $objectManager->create("Magento\Eav\Setup\EavSetupFactory");
                    $eavSetup = $eavSetupFactory->create();
                    $entityTypeId = 4; // 4 is catalog_product
                    $eavSetup->removeAttribute($entityTypeId, $code);

                }
                $this->messageManager->addSuccess(
                    __(
                        'A total of %1 record(s) have been deleted.',
                        count($answerIds)
                    )
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        return $this->resultRedirectFactory->create()->setPath('yourproduct/*/index');
    }


}
