<?php

/**
 * Fds_Customcatalog
 * Fds - fdallserra 2020
 * Helper:
 *    isEnable >> from Admin panel
 */

namespace Fds\Customcatalog\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{

    protected $context;

    const XML_PATH_CUSTOMCATALOG = 'customcatalog/';

    public function __construct(Context $context)
    {
        $this->context = $context;
        parent::__construct($context);
    }

    public function isEnable()
    {
        return $this->scopeConfig->getValue('customcatalog/general/enable', ScopeInterface::SCOPE_STORE);
    }

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_CUSTOMCATALOG .'general/'. $code, $storeId);
    }



}
