<?php
/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 * Question Model
 */

namespace Fds\Yourproduct\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Fds\Yourproduct\Api\Data\QuestionExtensionInterface;
use Fds\Yourproduct\Api\Data\QuestionInterface;

use Fds\Yourproduct\Helper\Data;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;

class Question extends AbstractModel implements QuestionInterface
{

    const QUESTION = 'question';
    const QUESTION_ID = 'question_id';
    const QUESTIONORDER = 'question_order';


    protected $_dataHelper;
    protected $_productCollectionFactory;
    protected $_connection;

    protected function _construct()
    {
        $this->_init('Fds\Yourproduct\Model\ResourceModel\Question');

    }

    protected $_urlModel;

    public function __construct(
        Context $context,
        Registry $registry,
        UrlInterface $urlModel,
        CollectionFactory $productCollectionFactory,
        Data $dataHelper,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection,
            $data
        );
        $this->_dataHelper = $dataHelper;
        $this->_urlModel = $urlModel;
        $this->_productCollectionFactory = $productCollectionFactory;

        $objectManager =   \Magento\Framework\App\ObjectManager::getInstance();
        $this->_connection = $objectManager->get('Magento\Framework\App\ResourceConnection')
            ->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');

    }

    public function getQuestion()
    {
        return $this->_getData(self::QUESTION);
    }

    public function setQuestion($question)
    {
        $this->setData(self::QUESTION);
    }

    public function getQuestionOrder()
    {
        return $this->_getData(self::QUESTIONORDER);
    }

    public function setQuestionOrder($questionOrder)
    {
        $this->setData(self::QUESTIONORDER);
    }


    //chiamata da index.phtml per costruire le domande
    //ritorna la label della domanda da tabella principale o da tabella collegata a store
    public function getQuestionLabel()
    {
        $question_id = $this->getQuestion_id();
        $storeId = $this->getCurrentStoreId();
        $result = $this->getQuestionAdditionalLabel($storeId);

        if ($result == ""){
            $result = $this->getQuestion();
        }

        return $result;
    }

    //chiamata da getQuestionLabel() per index.phtml per costruire le domande
    //chiamata da backend block/adminhtml/question/edit/tab/additional.php
    //ritorna l'eventuale label dalla tabella collegata allo store passato
    public function getQuestionAdditionalLabel($storeId){
        $question_id = $this->getQuestion_id();

        $result = '';

        $query = "SELECT *
                  FROM fdsyour_question_store_label
                  WHERE question_id = " . $question_id . " AND store_id = " . $storeId;

        $labels = $this->_connection->fetchAll($query);

        foreach ($labels as $label){
            $result = $label['question'];
            break;
        }
        return $result;
    }


    public function getRelatedAnswerIds($questionId)
    {
        $query = 'SELECT attribute_id
                  FROM fdsyour_question_attribute
                  WHERE question_id = '. (int)$questionId;

        $relatedAnswerIds = $this->_connection->fetchCol($query);
        return $relatedAnswerIds;
    }


    /**
     * @param \Fds\Yourproduct\Api\Data\AnswerInterface[] $answers
     * @return void
     */
    public function setAnswers(array $answers)
    {
        // TODO: Implement setAnswers() method.
    }


    /////////////NON FUNZIONA
    public function getAnswers()
    {
        $question_id = $this->getQuestion_id();

        $objectManager =   \Magento\Framework\App\ObjectManager::getInstance();
        $ansObject = $objectManager->create('Fds\Yourproduct\Model\Answer');

        $collection = $objectManager->create('Fds\Yourproduct\Model\ResourceModel\Answer\CollectionFactory');
        var_dump($collection->getData());
        $collection->addFieldToFilter('question_id', $question_id);

        $result  = array();
        $i = 0;
        foreach ($collection as $answer){
            $attribute_id = $answer->getAttribute_id();
            $attribute_data = $ansObject->getAttributeDataById($attribute_id);
            if (count($attribute_data) > 0){
                $result[$i]['attribute_id'] = $attribute_id;
                $result[$i]['attribute_code'] = $attribute_data['attribute_code'];
                $result[$i]['frontend_label'] = $attribute_data['frontend_label'];
                $i++;
            }
        }
        return $result;


        // TODO: Implement setAnswers() method.
    }

    public function getAnswerIds()
    {
        // TODO: Implement setAnswers() method.
    }

    //--------------------------------------------------
    //funzione di servizio che ritorna l'ID dello store
    public function getCurrentStoreId()
    {
        $objectManager =   \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->get('Magento\Store\Model\StoreManagerInterface');
        $currentStore = $storeManager->getStore();
        $storeId = $storeManager->getStore()->getId();

        return $storeId;
    }

}
