<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Controller\Adminhtml\Question;

use Fds\Yourproduct\Controller\Adminhtml\Question;

class RelatedAnswers extends Question
{
    public function execute()
    {
        if (empty($this->_model)) {
            $this->_model = $this->_questionFactory->create();

            $id = (int)$this->getRequest()->getParam('question_id');
            if ($id) {
                $this->_model->load($id);
            }
        }
        $this->_coreRegistry->register('related_pro_model', $this->_model);
        $this->_view->loadLayout()
            ->getLayout()
            ->getBlock('fds_yourproduct_relatedanswers')
            ->setAnswersRelated(
                $this->getRequest()->getPost('answers_related', null)
            );

        $this->_view->renderLayout();
    }
}
