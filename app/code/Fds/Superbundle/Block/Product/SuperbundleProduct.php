<?php

/**
 * Fds_Superbundle
 * Fds - fdallserra 2018
 * Product: Single product info:
 *      isSuperBundle, getParentBundles, getUrlSingleProduct,
 * Product: Bundle info (if BoxBundle):
 *      getDataBox(box)
 */

namespace Fds\Superbundle\Block\Product;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;

class SuperbundleProduct extends Template
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var \Magento\Catalog\Model\Product
     */
    protected $product;


    protected $_moduleManager;

    /**
     * ProductView constructor.
     * @param Template\Context $context
     * @param array $data
     * @param Registry $registry
     */
    public function __construct(
        Template\Context $context,
        Registry $registry,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    )
    {
        $this->registry = $registry;
        $this->_moduleManager = $moduleManager;
        parent::__construct($context, $data);
    }

    /**
     * @return \Magento\Catalog\Model\Product
     */
    public function getProduct()
    {
        if (is_null($this->product)) {
            $this->product = $this->registry->registry('product');
        }

        return $this->product;
    }

    public function isSuperBundle(){
        $bundles = $this->getParentBundles();
        return (!(empty($bundles)));
    }

    public function getParentBundles()
    {
        $id_to_find = $this->product->getId();
        $bundles = array();

        $helper = \Magento\Framework\App\ObjectManager::getInstance()->get('Fds\Superbundle\Helper\Data');
        $moduleAdminEnabled = ($helper->isEnable());

        if ($moduleAdminEnabled) {

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection');
            $productCollection = $productCollection
                ->addFieldToFilter('type_id', 'bundle')
                ->addFieldToFilter('fdssb_box', 1);

            foreach ($productCollection as $product) {
                $children_ids_by_option = $product
                    ->getTypeInstance(true)
                    ->getChildrenIds($product->getId(), false);

                $ids = array();
                foreach ($children_ids_by_option as $array) {
                    $ids = array_merge($ids, $array);
                }

                if (in_array($id_to_find, $ids)) {
                    $bundles[] = $product->getId();
                }
            }
        }

        return $bundles;
    }


    public function getDataBox($box)
    {
        $dataBox = [];

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $priceHelper = $objectManager->create('Magento\Framework\Pricing\Helper\Data');

        $box = $objectManager->create('Magento\Catalog\Model\Product')
            ->load($box->getEntityId());

        if ($box->isSaleable()) {
            $dataBox['entityId'] = $box->getEntityId();

            $dataBox['name'] = $box->getName();

            $descHelper = $objectManager->create('Magento\Catalog\Helper\Output');

            $description = $descHelper->productAttribute($box, $box->getDescription(), 'description');
            $dataBox['description'] = $description;

            $short_description = $descHelper->productAttribute($box, $box->getShortDescription(), 'short_description');
            $dataBox['short_description'] = $short_description;

            $helperImport = $objectManager->get('\Magento\Catalog\Helper\Image');
            $image = $helperImport->init($box, 'product_page_image')
                ->setImageFile($box->getImage()) // image,small_image,thumbnail
                ->getUrl();
            $dataBox['image'] = $image;

            //PRICES
            //not consider maximalPrice because in SuperBundle is the same of minimalPrice
            //there are no 'optionals'
            $bundleObj = $box->getPriceInfo()->getPrice('regular_price');
            $minRaw = $bundleObj->getMinimalPrice()->getValue();
            $regular_amount = $minRaw;
            $regular_price = $priceHelper->currency($minRaw, true, false);
            $dataBox['reg_price'] = $regular_price;

            $bundleObj = $box->getPriceInfo()->getPrice('final_price');
            $minRaw = $bundleObj->getMinimalPrice()->getValue();
            $amount = $minRaw;
            $price = $priceHelper->currency($minRaw, true, false);
            $dataBox['price'] = $price;
            $dataBox['reg_amount'] = $regular_amount;
            $dataBox['amount'] = $amount;

            $selected = $box->getAttributeText('fdssb_box_selected');
            $dataBox['selected'] = ($selected=='Yes'); //Yes or No

            $cartHelper = $objectManager->get('\Magento\Checkout\Helper\Cart');
            $url_add_to_cart = $cartHelper->getAddUrl($box);
            $selectionCollection = $box->getTypeInstance(true)
                ->getSelectionsCollection(
                    $box->getTypeInstance(true)->getOptionsIds($box),
                    $box
                );

            //quantity 1 default
            $bundleOptions = 'qty/1/?';
            foreach ($selectionCollection as $selection) {
                $bundleOptions .= '&bundle_option[' . $selection->getOptionId() . ']=' . $selection->getSelectionId();
                $bundleOptions .= '&bundle_option_qty[' . $selection->getOptionId() . ']=' . $selection->getSelectionQty();
                $dataBox['qty'] = round($selection->getSelectionQty());
            }
            $url_add_to_cart .= $bundleOptions;

            $dataBox['url_add_to_cart'] = $url_add_to_cart;

        }

        //echo "<pre>";
        //var_dump($dataBox);
        //echo "</pre>";
        //exit;

        return $dataBox;
    }

    /**
     * @return string
     */
    public function bespokeproductIsEnabled(){
        return $this->_moduleManager->isEnabled('Fds_Bespokeproduct');
    }

    /**
     * Whether a module is enabled in the configuration or not
     *
     * @param string $moduleName Fully-qualified module name
     * @return boolean
     */
    /*public function isModuleEnabled($moduleName)
    {
        return $this->_moduleManager->isEnabled($moduleName);
    }*/

}
