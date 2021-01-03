<?php
/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 * Question Block
 */

namespace Fds\Yourproduct\Block;


class Question extends \Magento\Framework\View\Element\Template
{

    protected $_questionFactory;
    protected $_questionCollectionFactory;
    protected $_questionRepository;
    protected $_answerFactory;
    protected $_answerCollectionFactory;

    public function __construct(
                \Magento\Backend\Block\Template\Context $context,
                \Magento\Framework\View\Result\PageFactory $pageFactory,
                \Fds\Yourproduct\Model\QuestionFactory $questionFactory,
                \Fds\Yourproduct\Model\ResourceModel\Question\CollectionFactory $questionCollectionFactory,
                \Fds\Yourproduct\Model\QuestionRepository $questionRepository,
                \Fds\Yourproduct\Model\AnswerFactory $answerFactory,
                \Fds\Yourproduct\Model\ResourceModel\Answer\CollectionFactory $answerCollectionFactory,

                array $data = []
            )

    {
        $this->_questionRepository = $questionRepository;
        $this->_questionFactory = $questionFactory;
        $this->_questionCollectionFactory = $questionCollectionFactory;

        $this->_answerFactory = $answerFactory;
        $this->_answerCollectionFactory = $answerCollectionFactory;

        parent::__construct($context, $data);
    }


    //chiamata da index.phtml per costruire le domande
    //ritorna un array con i dati di tutte le domande con status 1
    //question_id, question, multiselect
    public function getQuestions()
    {
        $questionCollection = $this->_questionCollectionFactory->create();
        $questionCollection->addFieldToFilter('status', 1);
        $questionCollection->setOrder('question_order', 'asc');

        $i = 0;
        $questions = array();

        foreach ($questionCollection as $question){
            $question_id = $question->getQuestion_id();
            $answers = $this->getAnswers($question_id);
            //NON FUNZIONA $answers = $question->getAnswers();
            if (count($answers) > 0){
                $questions[$i]['question_id'] = $question_id;
                $questions[$i]['question'] = $question->getQuestionLabel();
                $questions[$i]['multiSelect'] = ($question->getMulti_select() == 1);
                $i++;
            }
        }

        return $questions;
    }

    //chiamata da getQuestions()
    //ritorna array di risposte
    //attribute_id/code-id/label (se c'e' dello store)
    public function getAnswers($question_id)
    {
        $result  = array();
        $ansObject = $this->_answerFactory->create();
        $answers = $this->_answerCollectionFactory->create();
        $answers->addFieldToFilter('question_id', $question_id);
        $i = 0;
        foreach ($answers as $answer){
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
    }


    //chiamata da result.phtml
    //per costruire la lista dei prodotti selezionati
    //prende array di attribute_code
    //ritorna collezione di prodotti
    //      filtri: attributi passati / visibility / enable / storeId
    public function getProductsResult($attribs)
    {
        $ansObject = $this->_answerFactory->create();
        return $ansObject->getAttributeProductCollection($attribs);
    }


    //chiamata da result.phtml
    //per costruire la lista delle risposte date
    //prende attrib_code per far vedere la lista delle scelte
    //ritorna  label, se presente, quella dello store
    public function getAttribLabel($code){
        $answer = $this->_answerFactory->create();
        $attributeInfo = $answer->getAttributeDataByCode($code);
        return $attributeInfo['frontend_label'];
    }


    //chiamata da result.phtml
    // prende l'id del prodotto
    //ritorna un array con i dati del prodotto
    //id, name, short_description, url
    public function getProductData($productId)
    {
        $productData = array();

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $descHelper = $objectManager->create('Magento\Catalog\Helper\Output');

        $product = $objectManager->create('Magento\Catalog\Model\Product')
            ->load($productId);

        $productData['id'] = $product->getId();
        $productData['name'] = $this->escapeHtml($product->getName());
        $productData['short_description'] = $descHelper->productAttribute($product, $product->getShortDescription(), 'short_description');
        $productData['url'] = $product->getProductUrl();

        return $productData;
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
