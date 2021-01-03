<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Controller\Adminhtml\Question;

use Fds\Yourproduct\Controller\Adminhtml\Question;
use Magento\Framework\Exception\LocalizedException;

class Save extends Question
{
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $model = $this->_questionFactory->create();

            $id = $this->getRequest()->getParam('question_id');
            if ($id) {
                $model->load($id);
            }

            try {

                if (!(is_numeric($data['question_order']))){
                    $data['question_order'] = '0';
                }

                $modelUrl = $this->_questionFactory->create();
                if ($id) {
                    $modelURL = $modelUrl->getCollection()
                        ->addFieldToFilter('question_id', ['neq' => $id]);
                    $idToAdd = $id;
                } else {
                    $modelURL = $modelUrl->getCollection();
                    $getLastId = $modelURL;
                    $getLastIdData = $getLastId->getLastItem();
                    $lastId = $getLastIdData->getId();
                    $idToAdd = $lastId + 1;
                }

                $model->setData($data);

                $model->setType("question");
                $model->save();

                $questionId = $model->getId();

                $this->saveAdditionalLabels($model, $data);

                $this->saveAnswers($model, $data);

                $this->messageManager
                    ->addSuccess(__('The question has been saved.'));
                $this->_objectManager
                    ->get('Magento\Backend\Model\Session')
                    ->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect(
                        '*/*/edit',
                        ['question_id' => $questionId, '_current' => true]
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
                    'question_id' => $this->getRequest()
                        ->getParam('question_id')
                ]
            );
            return;
        }
        $this->_redirect('*/*/');
    }

    public function saveAdditionalLabels($model, $post){
        $questionId = $model->getId();

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->create("\Magento\Store\Model\StoreManagerInterface");
        $stores = $storeManager->getStores(true, false);
        foreach ($stores as $store) {
            $storeId = $store->getId();
            $key = "question_" . $storeId;
            if (array_key_exists($key, $post)){
                $additionalLabel = trim($post[$key]);
                $oldLabel = $model->getQuestionAdditionalLabel($storeId);
                if ($additionalLabel <> $oldLabel){

                    if ($additionalLabel == ""){
                        $query = 'DELETE FROM fdsyour_question_store_label
                            WHERE
                              question_id=' . $questionId . ' AND
                              store_id = ' . $storeId . ';';
                        $this->_resource->getConnection()
                            ->query($query);

                    } elseif ($oldLabel == ""){
                        $query = 'INSERT INTO fdsyour_question_store_label
							(question_id,store_id, question)
							VALUES (' .
                                $questionId . ',' .
                                $storeId . ',
							    "' . $additionalLabel . '");';
                        $this->_resource->getConnection()
                            ->query($query);
                    } else {
                        $query = 'UPDATE fdsyour_question_store_label
							SET question = "' . $additionalLabel . '"
							WHERE
							    question_id = ' . $questionId . '
							    AND store_id = ' . $storeId . ';';
                        $this->_resource->getConnection()
                            ->query($query);
                    }
                }
            }
        }
    }

    public function saveAnswers($model, $post)
    {
        $questionId = $model->getId();

        if (isset($post['relatedanswers'])){
            $relatedanswers = $post['relatedanswers'];
            $newRelatedIds = explode('&', $relatedanswers);

            $questionmanager = $this->_questionFactory->create();
            $oldRelatedIds = $questionmanager
                ->getRelatedAnswerIds($questionId);

            $delete = array();
            $insert = array();

            foreach ($oldRelatedIds as $old){
                if (!(in_array($old, $newRelatedIds))){
                    $delete[] = $old;
                }
            }

            foreach ($newRelatedIds as $new){
                if (!(in_array($new, $oldRelatedIds))){
                    $insert[] = $new;
                }
            }

            if (count($delete) > 0) {
                foreach ($delete as $deleteId) {
                    $query = 'DELETE FROM fdsyour_question_attribute
                      WHERE
                        question_id = ' . $questionId .
                        ' AND attribute_id = '. $deleteId .';';
                    $this->_resource->getConnection()
                        ->query($query);
                }
            }

            if (count($insert) > 0) {
                foreach ($insert as $relatedId) {
                    if ($relatedId){
                    //delete the link if the attribute is linked to another question
                    $query = 'DELETE FROM fdsyour_question_attribute
                      WHERE attribute_id = '. $relatedId .';';
                    $this->_resource->getConnection()
                        ->query($query);

                    $query = 'INSERT INTO fdsyour_question_attribute
                      (question_id, attribute_id)
                      VALUES (' . $questionId . ',' . $relatedId . ');';
                    $this->_resource->getConnection()
                        ->query($query);
                    }
                }
            }
        }
    }
}
