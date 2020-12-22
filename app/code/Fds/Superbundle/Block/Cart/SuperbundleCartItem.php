<?php

/**
 * Fds_Superbundle
 * Fds - fdallserra 2018
 * Cart: Bundle product infos:
 *      isBoxBundle, getSingleProduct, getUrlSingleProduct, getIdSingleProduct
 */

namespace Fds\Superbundle\Block\Cart;

use Magento\Framework\View\Element\Template;

class SuperbundleCartItem extends Template
{

    public function getUrlSingleProduct($bundle)
    {
        $url_single_product = '';
        $single_product = $this->getSingleProduct($bundle);
        if (!(is_null($single_product))) {
            $url_single_product = $single_product->getProductUrl();
        }
        return $url_single_product;
    }


    public function getIdSingleProduct($bundle)
    {
        $id_single_product = 0;
        $single_product = $this->getSingleProduct($bundle);
        if (!(is_null($single_product))) {
            $id_single_product = $single_product->getId();
        }
        return $id_single_product;
    }


    public function isBoxBundle($bundle)
    {
        return ($this->getSingleProduct($bundle) <> null);
    }


    public function getSingleProduct($bundle)
    {
        $single_product = null;

        $helper = \Magento\Framework\App\ObjectManager::getInstance()->get('Fds\Superbundle\Helper\Data');
        $moduleAdminEnabled = ($helper->isEnable());

        if ($moduleAdminEnabled) {
            if ($bundle->isSaleable()) {
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $_product_complete = $objectManager->create('Magento\Catalog\Model\Product')
                    ->load($bundle->getId());

                if (($bundle->getTypeId() == 'bundle') && ($_product_complete->getAttributeText('fdssb_box') == 'Yes')) {
                    $_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                    $options = $_objectManager->create('Magento\Bundle\Model\Option')
                        ->getResourceCollection()
                        ->setProductIdFilter($bundle->getId())
                        ->setPositionOrder();

                    $typeInstance = $_objectManager->get('Magento\Bundle\Model\Product\Type');
                    $selections = $typeInstance->getSelectionsCollection($typeInstance->getOptionsIds($bundle), $bundle);
                    if (count($selections) == 1) {
                        foreach ($selections as $selection) {
                            $single_product = $selection;
                        }
                    }
                }
            }
        }

        return $single_product;
    }

}