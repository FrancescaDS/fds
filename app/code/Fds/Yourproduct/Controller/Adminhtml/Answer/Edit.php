<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Controller\Adminhtml\Answer;

use Fds\Yourproduct\Controller\Adminhtml\Answer;

class Edit extends Answer
{
    public function execute()
    {

        $id = $this->getRequest()->getParam('attribute_id');

        $model = \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Magento\Eav\Model\Attribute::class);

        if ($id) {
            $model->load($id);


            if (!$model->getAttributeId()) {
                $this->messageManager
                    ->addError(__('This answer no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $data = $this->_getSession()->getFormData(true);

        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('answer_answer', $model);

        $this->_view->loadLayout();

        $this->_view->getLayout()->initMessages();

        $this->_view->renderLayout();
    }
}
