<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Controller\Adminhtml\Question;

use Fds\Yourproduct\Controller\Adminhtml\Question;

class Edit extends Question
{
    public function execute()
    {
        $id = $this->getRequest()->getParam('question_id');
        $model = $this->_questionFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getQuestionId()) {
                $this->messageManager
                    ->addError(__('This question no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $data = $this->_getSession()->getFormData(true);

        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('question_question', $model);


        $this->_view->loadLayout();

        $this->_view->getLayout()->initMessages();

        $this->_view->renderLayout();

    }
}
