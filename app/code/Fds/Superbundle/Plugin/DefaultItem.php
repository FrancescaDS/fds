<?php

/**
 * Fds_Superbundle
 * Fds - fdallserra 2018
 * Minicart
 * Changing Minicart for Superbundle
 *
 * IF product is BoxBundle
 * product_url and configure_url (edit link) must go to the superbundle page
 * NO show options
 * web/template/minicart/item/default.html
 */

namespace Fds\Superbundle\Plugin;

use Magento\Quote\Model\Quote\Item;

class DefaultItem
{
    public function aroundGetItemData($subject, \Closure $proceed, Item $item)
    {
        $data = $proceed($item);
        $product = $item->getProduct();

        $atts = array();

        $helper = \Magento\Framework\App\ObjectManager::getInstance()->get('Fds\Superbundle\Helper\Data');
        $moduleAdminEnabled = ($helper->isEnable());

        if ($moduleAdminEnabled) {

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $blockObj = $objectManager->create('Fds\Superbundle\Block\Cart\SuperbundleCartItem');

            //if $superbundle_url <> '' the product is a BoxBundle
            $superbundle_url = $blockObj->getUrlSingleProduct($product);
            if ($superbundle_url <> '') {
                $atts = [
                    "options" => '',
                    "product_url" => $superbundle_url,
                    "configure_url" => $superbundle_url
                ];
            }
        }
        return array_merge($data, $atts);
    }
}