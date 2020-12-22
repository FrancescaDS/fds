<?php

/**
 * Fds_Superbundle
 * Fds - fdallserra 2018
 * Cart: sets template to cart/item/default.phtml
 */

namespace Fds\Superbundle\Block\Cart;

class SuperbundleCart
{
    public function afterGetItemRenderer(\Magento\Checkout\Block\Cart\AbstractCart $subject, $result)
    {
        $helper = \Magento\Framework\App\ObjectManager::getInstance()->get('Fds\Superbundle\Helper\Data');
        $moduleAdminEnabled = ($helper->isEnable());

        if ($moduleAdminEnabled) {
            $result->setTemplate('Fds_Superbundle::cart/item/default.phtml');
            return $result;
        }
    }
}
