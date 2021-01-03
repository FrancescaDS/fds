<?php
/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 * Question Model
 */

namespace Fds\Yourproduct\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Fds\Yourproduct\Api\Data\AnswerExtensionInterface;
use Fds\Yourproduct\Api\Data\AnswerInterface;

class Answer extends AbstractExtensibleModel implements AnswerInterface
{

    const QUESTIONID = 'question_id';
    const ATTRIBUTEID = 'attribute_id';

    protected function _construct()
    {
        $this->_init(ResourceModel\Answer::class);
    }

    public function getQuestion_id()
    {
        return $this->_getData(self::QUESTIONID);
    }

    public function setQuestion_id($question_id)
    {
        $this->setData(self::QUESTIONID);
    }

    public function getAttribute_id()
    {
        return $this->_getData(self::ATTRIBUTEID);
    }

    public function setAttribute_id($attribute_id)
    {
        $this->setData(self::ATTRIBUTEID);
    }


    //chiamata da block->getAttribLabels (per la lista delle risposte date)
    //prende un attrib_code
    //ritorna array con tutti i dati relativi all'attributo
    //attrib_id, attrib_code, frontend_label
    public function getAttributeDataByCode($code) {
        $attributeData = array();

        //1) prendo tutti i dati dell'attributo con il code
        $query = "SELECT attribute_id, attribute_code, frontend_label FROM eav_attribute
                  WHERE attribute_code = '" . $code . "'";

        $objectManager =   \Magento\Framework\App\ObjectManager::getInstance();
        $connection = $objectManager->get('Magento\Framework\App\ResourceConnection')
            ->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');
        $attributes = $connection->fetchAll($query);

        foreach($attributes as $attribute) {
            //primo (e unico) risulato della query
            //in result ho tutti i dati dell'attributo
            $attributeData = $attribute;
            $attribute_id = $attribute['attribute_id'];
            break;
        }

        //2) verifico se l'attributo ha una label per lo store in cui sono
        $label = $this->getAttributeAdditionalLabel($attribute_id);
        if ($label."" <> ""){
            $attributeData['frontend_label'] = $label;
        }
        return $attributeData;
    }


    //chiamata da block->getAnswers per index.phtml per la lista delle risposte di ogni domanda
    //prende l'id dell'attributo
    //ritorna tutti i dati dell'attributo con l'eventuale label per lo store attuale
    public function getAttributeDataById($attribute_id){
        $attributeData = array();

        //1) prendo tutti i dati dell'attributo con l'id
        $attributeModel = \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Magento\Eav\Model\Attribute::class)
            ->load($attribute_id);

        $attribute_code = $attributeModel->getData('attribute_code');

        if ($this->checkAttributeProducts($attribute_code)) {
            $attributeData['attribute_id'] = $attribute_id;
            $attributeData['attribute_code'] = $attribute_code;

            //2) verifico se l'attributo ha una label per lo store in cui sono
            $label = $this->getAttributeAdditionalLabel($attribute_id);
            if ($label == ''){
                $label = $attributeModel->getData('frontend_label');
            }
            $attributeData['frontend_label'] = $label;
        }
        return $attributeData;
    }


    //chiamata da $this->getAttributeData per verificare che l'attributo (la risposta) sia collegato
    //ad almeno un prodotto enable e con visibilita' search o catalog o searchcatalog
    public function checkAttributeProducts($attribute_code)
    {
        $attrib[0] = $attribute_code;
        $result = ($this->getAttributeProductCollection($attrib)->count() > 0);
        return $result;
    }


    //chiamata da this->checkAttributeProducts per this->getAttributeData per index.phtml  per check attributi legati a prodotti validi
    //chiamata da block->getProductsResult per result.phtml per costruire la lista dei prodotti selezionati
    //prende array di attribute_code
    //ritorna collezione di prodotti
    //      filtri: attributi passati / visibility / enable / storeId
    public function getAttributeProductCollection($attribute_codes)
    {
        $storeId = $this->getCurrentStoreId();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection');
        $productCollection = $productCollection
            ->addAttributeToSelect('*')
            ->addFieldToFilter('type_id', 'simple')
            ->addStoreFilter($storeId)
            ->addAttributeToFilter('status', 1) //enable
            ->addAttributeToFilter('visibility', array('in'=>array(2,3,4))); //not vis indiv1, search2, catalog3, search and catalog4

        foreach ($attribute_codes as $code){
            $condition = array();
            if(is_array($code)){
                $multiCode = $code;
                foreach ($multiCode as $singleCode) {
                    if (strpos($singleCode, 'fdsyour_') === 0) {
                        $condition[] = array('attribute'=> $singleCode, 'eq'=>1);
                    }
                }
            } else {
                if (strpos($code, 'fdsyour_') === 0) {
                    $condition[] = array('attribute'=> $code, 'eq'=>1);
                }
            }
            if ($condition){
                $productCollection = $productCollection
                    ->addAttributeToFilter($condition);
            }

        }

        return $productCollection;
    }


    //chiamato da block->getAnswers per index.phtml per la lista delle risposte di ogni domanda
    //prende l'id dell'attributo
    //ritorna l'eventuale label per lo store attuale
    public function getAttributeAdditionalLabel($attribute_id)
    {
        $label = "";

        $storeId = $this->getCurrentStoreId();

        $attributeModel = \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Magento\Eav\Model\Attribute::class)
            ->load($attribute_id);

        $storeLabels = array();
        $storeLabels = $attributeModel->getStoreLabels();
        if (array_key_exists($storeId,$storeLabels)) {
            $label = $storeLabels[$storeId];
        }

        return $label;
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
