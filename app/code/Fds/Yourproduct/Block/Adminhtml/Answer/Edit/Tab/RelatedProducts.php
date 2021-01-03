<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Block\Adminhtml\Answer\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Helper\Data;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Registry;
use Magento\Store\Model\WebsiteFactory;

class RelatedProducts extends Extended implements TabInterface
{
    protected $_coreRegistry = null;
    protected $_productCollectionFactory;
    protected $_websiteFactory;

   public function __construct(
        Context $context,
        Data $backendHelper,
        CollectionFactory $productCollectionFactory,
        WebsiteFactory $websiteFactory,
        Registry $coreRegistry,
        array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_websiteFactory = $websiteFactory;
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $backendHelper, $data);
    }

   protected function _construct()
    {
        parent::_construct();
        $this->setId('related_products_section');
        $this->setDefaultSort('attribute_id');
        $this->setUseAjax(true);
        if ($this->getAnswer() && $this->getAnswer()->getId()) {
            $this->setDefaultFilter(['in_products' => 1]);
        }
    }

    /**
     * @return mixed
     */
    public function getAnswer()
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
        // Set custom filter for in post flag
        if ($column->getId() == 'in_products') {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()
                    ->addFieldToFilter('entity_id', ['in' => $productIds]);
            } else {
                if ($productIds) {
                    $this->getCollection()
                        ->addFieldToFilter('entity_id', ['nin' => $productIds]);
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

        //exclude bundled products part of superbundle (bundle program)
        /*$programBundleAttribute = \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Magento\Eav\Model\Attribute::class);
        $programBundleAttribute->loadByCode(4, 'bundle_program');
        $programBundle_id = $programBundleAttribute->getAttributeId();
*/


        $collection = $this->_productCollectionFactory->create()
            ->addAttributeToSelect('*')
            ->addFieldToFilter('type_id', 'simple')
            ->addAttributeToFilter('status', 1) //enable
            ->addAttributeToFilter('visibility', array('in'=>array(2,3,4))) //not vis indiv1, search2, catalog3, search and catalog4

            ->joinField(
                'websites',
                'catalog_product_website',
                'website_id',
                'product_id=entity_id',
                null,
                'left'
            );


        $this->setCollection($collection);

       // print collection query
       // $collection->getSelect()->__toString();
       // echo $collection->getSelect();

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
        if (!$this->isReadonly()) {
            $this->addColumn(
                'in_products',
                [
                    'type' => 'checkbox',
                    'name' => 'in_products',
                    'values' => $this->_getSelectedProducts(),
                    'align' => 'center',
                    'index' => 'entity_id',
                    'header_css_class' => 'col-select',
                    'column_css_class' => 'col-select'
                ]
            );
        }

        $this->addColumn(
            'entity_id',
            [
                'header' => __('ID'),
                'sortable' => true,
                'index' => 'entity_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        $this->addColumn(
            'name',
            [
                'header' => __('Name'),
                'index' => 'name',
                'header_css_class' => 'col-name',
                'column_css_class' => 'col-name'
            ]
        );

        $this->addColumn(
            'sku',
            [
                'header' => __('SKU'),
                'index' => 'sku',
                'header_css_class' => 'col-sku',
                'column_css_class' => 'col-sku'
            ]
        );

        if (!$this->_storeManager->isSingleStoreMode()) {
            $this->addColumn(
                'websites',
                [
                    'header' => __('Websites'),
                    'sortable' => false,
                    'index' => 'websites',
                    'type' => 'options',
                    'options' => $this->_websiteFactory
                        ->create()->getCollection()->toOptionHash(),
                    'header_css_class' => 'col-websites',
                    'column_css_class' => 'col-websites'
                ]
            );
        }

        return parent::_prepareColumns();
    }

    /**
     * @return mixed|string
     */
    public function getGridUrl()
    {
        return $this->getData(
            'grid_url'
        ) ? $this->getData(
            'grid_url'
        ) : $this->getUrl(
            'yourproduct/answer/relatedProductsGrid',
            ['_current' => true]
        );
    }

    /**
     * @return mixed
     */
    protected function _getSelectedProducts()
    {
        $products = $this->getProductsRelated();
        if (!is_array($products)) {
            $products = $this->getSelectedProducts();
        }

        return $products;
    }

    /**
     * @return array
     */
    public function getSelectedProducts()
    {
        $attributeId = $this->getAnswer()->getAttributeId();
        $products = [];
        if($attributeId){
            $model = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Magento\Eav\Model\Attribute::class);
            $model->load($attributeId);

            $code = $model->getAttributeCode();

            $collection = $this->_productCollectionFactory->create()
                ->addAttributeToSelect('*')
                ->addFieldToFilter($code, 1);

            foreach ($collection as $product){
                $products[] = $product->getId();
            }
        }

        return $products;
    }

    /**
     * @return mixed
     */
    public function getTabLabel()
    {
        return __('Related Products');
    }

    /**
     * @return mixed
     */
    public function getTabTitle()
    {
        return __('Related Products');
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
