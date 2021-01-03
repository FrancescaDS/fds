<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Block\Adminhtml\Question\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Helper\Data;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Catalog\Api\ProductAttributeRepositoryInterface;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Framework\Registry;

class RelatedAnswers extends Extended implements TabInterface
{
    protected $_coreRegistry = null;
    protected $_searchCriteriaBuilder;
    protected $_attributeRepository;
    protected $_sortOrderBuilder;
    protected $_attributeFactory;

    public function __construct(
        Context $context,
        Data $backendHelper,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ProductAttributeRepositoryInterface $attributeRepository,
        SortOrderBuilder $sortOrderBuilder,
        Attribute $attributeFactory,
        Registry $coreRegistry,
        array $data = []
    ) {
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_attributeRepository = $attributeRepository;
        $this->_sortOrderBuilder = $sortOrderBuilder;
        $this->_attributeFactory = $attributeFactory;
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $backendHelper, $data);
    }


    protected function _construct()
    {
        parent::_construct();
        $this->setId('related_answers_section');
        $this->setDefaultSort('question_id');
        $this->setUseAjax(true);
        if ($this->getQuestion() && $this->getQuestion()->getId()) {
            $this->setDefaultFilter(['in_answers' => 1]);
        }
    }

    /**
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->_coreRegistry->registry('related_pro_model');
    }

    /**
     * @param Column $column
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_answers') {
            $answerIds = $this->_getSelectedAnswers();

            if (empty($answerIds)) {
                $answerIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()
                    ->addFieldToFilter('fdsyour_question_attribute.attribute_id', ['in' => $answerIds]);
            } else {
                if ($answerIds) {
                    $this->getCollection()
                        ->addFieldToFilter('fdsyour_question_attribute.attribute_id', ['nin' => $answerIds]);
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }

        return $this;
    }

    /**
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareCollection()
    {
        $collection = $this->getAttributeCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @return bool
     */
    public function isReadonly()
    {
        return false;
    }

    /**
     * @return $this
     * @throws \Exception
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_answers',
            [
                'type' => 'checkbox',
                'name' => 'in_answers',
                'values' => $this->_getSelectedAnswers(),
                'align' => 'center',
                'index' => 'attribute_id',
                'header_css_class' => 'col-select',
                'column_css_class' => 'col-select'
            ]
        );

        $this->addColumn(
            'attribute_id',
            [
                'header' => __('Attribute ID'),
                'sortable' => true,
                'index' => 'attribute_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        $this->addColumn(
            'attribute_code',
            [
                'header' => __('Attribute code'),
                'index' => 'attribute_code',
                'header_css_class' => 'col-name',
                'column_css_class' => 'col-name'
            ]
        );

        $this->addColumn(
            'frontend_label',
            [
                'header' => __('Frontend label'),
                'index' => 'frontend_label',
                'header_css_class' => 'col-name',
                'column_css_class' => 'col-name'
            ]
        );

        $this->addColumn(
            'relatedquestion',
            [
                'header' => __('Question'),
                'sortable' => true,
                'index' => 'relatedquestion',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * @return mixed|string
     */
    public function xxxxgetGridUrl()
    {
        return $this->getData(
            'grid_url'
        ) ? $this->getData(
            'grid_url'
        ) : $this->getUrl(
            'yourproduct/question/relatedAnswersGrid',
            ['_current' => true]
        );
    }

    /**
     * @return mixed
     */
    protected function _getSelectedAnswers()
    {
        $answers = $this->getAnswersRelated();
        if (!is_array($answers)) {
            $answers = $this->getSelectedAnswers();
        }

        return $answers;
    }


    /**
     * @return array
     */
    public function getSelectedAnswers()
    {
        $answers = array();
        $collection = $this->getAttributeCollection();
        $collection->addFieldToFilter('fdsyour_question_attribute.question_id', $this->getQuestion()->getId());
        foreach ($collection as $answer){
            $answers[] = $answer->getAttribute_id();
        }

        return $answers;
    }

    public function getAttributeCollection(){
        $joinConditions = 'main_table.attribute_id = fdsyour_question_attribute.attribute_id';
        $joinConditionsQuestion = 'fdsyour_question_attribute.question_id = fdsyour_question.question_id';

        $needle = 'fdsyour';
        $collection = $this->_attributeFactory->getCollection()
            ->addFieldToFilter(\Magento\Eav\Model\Entity\Attribute\Set::KEY_ENTITY_TYPE_ID, 4)
            ->addFieldToFilter('attribute_code', array('like' => $needle.'%'))
            ->setOrder('attribute_id','ASC');
        $collection->getSelect()->joinLeft(
            ['fdsyour_question_attribute'],
            $joinConditions,
            []
        )->columns("fdsyour_question_attribute.question_id");

        $collection->getSelect()->joinLeft(
            ['fdsyour_question'],
            $joinConditionsQuestion,
            []
        )->columns("fdsyour_question.question as relatedquestion");

        return $collection;
    }

    /**
     * @return mixed
     */
    public function getTabLabel()
    {
        return __('Related Answers');
    }

    /**
     * @return mixed
     */
    public function getTabTitle()
    {
        return __('Related Answers');
    }

    /**
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

}
