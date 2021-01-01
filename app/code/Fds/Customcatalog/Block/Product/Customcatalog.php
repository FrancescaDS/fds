<?php
/**
 * Created by PhpStorm.
 * User: francescadallaserra
 * Date: 08/01/2020
 * Time: 16:38
 */

namespace Fds\Customcatalog\Block\Product;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;

class Customcatalog extends Template
{


    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var \Magento\Catalog\Model\Product
     */
    protected $product;

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

    /**
     * @return string
     * Return attribute description or short description from first enabled configurable IF
     * - simple with configurable parent
     * - description or short description
     * - the custom 'CUSTOM CATALOG: Description from Configurable' (or
     *   'CUSTOM CATALOG: Short Description from Configurable') attribute is 'Yes'
     */
    public function getConfigurableAttribute($_product, $_code, $_helper, $_call){
        $_attributeValue = '';

        if (($_code == "short_description" || $_code == "description") and ($_product->getTypeId() == 'simple')){
            $flagCode = 'fdscc_' . str_replace('_','', $_code);

            $flagValue = ($_helper->productAttribute($_product, $_product->$_call(), $flagCode)) ? $_product->getAttributeText($flagCode) : '';

            if ($flagValue == 'Yes' or (string)$flagValue == '1'){

                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $parentIds = $objectManager->create('Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable')->getParentIdsByChild($_product->getId());

                if(isset($parentIds[0])){
                    $descHelper = $objectManager->create('Magento\Catalog\Helper\Output');

                    foreach ($parentIds as $parentId){
                        $parent = $objectManager->create('Magento\Catalog\Model\Product')
                            ->load($parentId);
                        if ($parent) {
                            if ($parent->getStatus() == 1) {
                                $from_config = true;
                                if ($_code == 'short_description'){
                                    $_attributeValue = $descHelper->productAttribute($parent, $parent->getShortDescription(), 'short_description');
                                } else {
                                    $_attributeValue = $descHelper->productAttribute($parent, $parent->getDescription(), 'description');
                                }
                            }
                        }
                    }
                }
            }
        }

        return $_attributeValue;
    }


}
