<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Block\Adminhtml\Answer;

use Fds\Yourproduct\Model\AnswerFactory;
use Fds\Yourproduct\Model\ResourceModel\Answer\CollectionFactory;
use Fds\Yourproduct\Model\Status;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Framework\Registry;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;

class Grid extends Extended
{
    protected $_answerFactory;
    protected $_coreRegistry;
    protected $_status;
    protected $_attributeFactory;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        Data $backendHelper,
        AnswerFactory $answerFactory,
        CollectionFactory $answerCollectionFactory,
        Attribute $attributeFactory,
        Status $status,
        array $data = []
    ) {
        $this->_answerFactory = $answerFactory;
        $this->_answerCollectionFactory = $answerCollectionFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_status = $status;
        $this->_attributeFactory = $attributeFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('answerGrid');
        $this->setDefaultSort('frontend_label');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * @return $this NOT USED
     */
    protected function xxx_prepareCollection()
    {
        $collection = $this->_answerCollectionFactory->create();
        $collection->setOrder('frontend_label', 'asc');

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    public function _prepareCollection()
    {
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

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }


    /**
     * @return $this
     * @throws \Exception
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'attribute_id',
            [
                'header' => __('Attribute ID'),
                'type' => 'number',
                'index' => 'attribute_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
                'width' => '20px',
            ]
        );

        $this->addColumn(
            'frontend_label',
            [
                'header' => __('Frontend label'),
                'index' => 'frontend_label',
                'width' => '50px',
            ]
        );

        $this->addColumn(
            'relatedquestion',
            [
                'header' => __('Question'),
                'index' => 'relatedquestion',
                'width' => '20px',
            ]
        );

        $this->addColumn(
            'action',
            [
                'header' => __('Action'),
                'index' => 'status',
                'type' => 'action',
                'getter' => 'getId',
                'width' => '20px',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => [
                            'base' => '*/*/edit',
                        ],
                        'field' => 'attribute_id'
                    ]
                ],
                'filter' => false,
                'sortable' => false
            ]
        );
    }

    /**
     * @param \Magento\Catalog\Model\Product|\Magento\Framework\DataObject $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', ['attribute_id' => $row->getId()]);
    }

    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('answer');
        $this->getMassactionBlock()->addItem('delete', [
            'label' => __('Delete'),
            'url' => $this->getUrl('*/*/massDelete', ['' => '']),
            'confirm' => __('Are you sure?')
        ]);

        $statuses = $this->_status->getOptionArray();

        return $this;
    }
}
