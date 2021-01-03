<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Controller\Adminhtml\Question;

use Fds\Yourproduct\Controller\Adminhtml\Question;

class MassStatus extends Question
{
    /**
     * @return $this
     */
    public function execute()
    {
        $questionIds = $this->getRequest()->getParam('question');
        if (!is_array($questionIds) || empty($questionIds)) {
            $this->messageManager->addError(__('Please select question(s).'));
        } else {
            try {
                $status = (int)$this->getRequest()->getParam('status');
                foreach ($questionIds as $questionId) {
                    $question = $this->_questionFactory->create()
                        ->load($questionId);
                    $question->setIsActive($status)->save();
                }
                $this->messageManager->addSuccess(
                    __(
                        'A total of %1 record(s) have been updated.',
                        count($questionIds)
                    )
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        return $this->resultRedirectFactory->create()->setPath('yourproduct/*/index');
    }

}
