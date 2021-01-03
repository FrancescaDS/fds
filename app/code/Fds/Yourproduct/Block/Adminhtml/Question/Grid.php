<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Block\Adminhtml\Question;

use Fds\Yourproduct\Model\QuestionFactory;
use Fds\Yourproduct\Model\ResourceModel\Question\CollectionFactory;
use Fds\Yourproduct\Model\Status;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Framework\Registry;

class Grid extends Extended
{
    protected $_questionFactory;
    protected $_coreRegistry;
    protected $_status;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        Data $backendHelper,
        QuestionFactory $questionFactory,
        CollectionFactory $questionCollectionFactory,
        Status $status,
        array $data = []
    ) {
        $this->_questionFactory = $questionFactory;
        $this->_questionCollectionFactory = $questionCollectionFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_status = $status;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('questionGrid');
        $this->setDefaultSort('question_order');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->_questionCollectionFactory->create();
        $collection->setOrder('question_order', 'asc');

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
            'question_id',
            [
                'header' => __('Question ID'),
                'type' => 'number',
                'index' => 'question_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'question_order',
            [
                'header' => __('Order'),
                'type' => 'number',
                'index' => 'question_order',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'question',
            [
                'header' => __('Question'),
                'index' => 'question',
                'width' => '50px',
            ]
        );

        $this->addColumn(
            'multi_select',
            [
                'header' => __('Multiselect'),
                'index' => 'multi_select',
                'type' => 'options',
                'options' => ['1' => 'Yes', '0' => 'No'],
                'width' => '50px',
            ]
        );

        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
                'type' => 'options',
                'options' => ['1' => 'Enabled', '0' => 'Disabled'],
                'width' => '50px',
                'frame_callback' => [
                    $this->getLayout()
                        ->createBlock(
                            'Fds\Yourproduct\Block\Adminhtml\Grid\Column\Statuses'
                        ),
                    'decorateStatus'
                ],
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
                        'field' => 'question_id'
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
        return $this->getUrl('*/*/edit', ['question_id' => $row->getId()]);
    }

    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('question');
        $this->getMassactionBlock()->addItem('delete', [
            'label' => __('Delete'),
            'url' => $this->getUrl('*/*/massDelete', ['' => '']),
            'confirm' => __('Are you sure?')
        ]);

        $statuses = $this->_status->getOptionArray();

        array_unshift($statuses, ['label' => '', 'value' => '']);
        $this->getMassactionBlock()->addItem('status', [
            'label' => __('Change status'),
            'url' => $this->getUrl('*/*/massStatus', ['_current' => true]),
            'additional' => [
                'visibility' => [
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => __('Status'),
                    'values' => $statuses
                ]
            ]
        ]);

        return $this;
    }
}
