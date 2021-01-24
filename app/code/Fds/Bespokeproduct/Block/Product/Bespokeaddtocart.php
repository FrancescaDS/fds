<?php


namespace Fds\Bespokeproduct\Block\Product;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;

class Bespokeaddtocart extends Template
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

    protected $_presente;

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
     * @return array bespokeLink, bespokeLabel
     */
    public function getBespokeData($product){
        $bespokeData = array();
        $bespokeLink = $product->getResource()->getAttribute('fdsbp_link')->getFrontend()->getValue($product);
        $bespokeLabel = $product->getResource()->getAttribute('fdsbp_label')->getFrontend()->getValue($product);

        $bespokeData = [
            'bespokeLink' => $bespokeLink,
            'bespokeLabel' => $bespokeLabel
        ];

        return $bespokeData;
    }

    /**
     * @return string
     */
    public function getBespokeLink($product){
        return $this->getBespokeData($product)['bespokeLink'];
    }

    /**
     * @return string
     */
    public function getBespokeLabel($product){
        return $this->getBespokeData($product)['bespokeLabel'];
    }

    /**
     * @return boolean
     */
    public function superbundleIsEnabled(){
        return $this->_moduleManager->isEnabled('Fds_Superbundle');
    }

}
