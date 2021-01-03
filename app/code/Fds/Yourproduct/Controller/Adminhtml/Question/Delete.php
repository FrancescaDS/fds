<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Controller\Adminhtml\Question;

use Fds\Yourproduct\Controller\Adminhtml\Question;

class Delete extends Question
{
    /**
     * @return $this
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('question_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        $model = $this->_questionFactory->create()->load($id);
        if ($id && $model->getQuestionId()) {
            try {
                $model->delete();
                $this->messageManager
                    ->addSuccess(
                        __('The question has been deleted.')
                    );
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager
                    ->addError($e->getMessage());
                return $resultRedirect
                    ->setPath(
                        '*/*/edit',
                        ['question_id' => $id]
                    );
            }
        }
        $this->messageManager->addError(
            __('We can\'t find a question to delete.')
        );
        return $resultRedirect->setPath('*/*/');
    }
}
