<?php

/**
 * Fds_Superbundle
 * Fds - fdallserra 2018
 * Helper:
 *    isEnable >> from Admin panel
 */

namespace Fds\Superbundle\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{

    protected $context;

    const XML_PATH_SUPERBUNDLE = 'superbundle/';

    public function __construct(Context $context)
    {
        $this->context = $context;
        parent::__construct($context);
    }

    public function isEnable()
    {
        return $this->scopeConfig->getValue('superbundle/general/enable', ScopeInterface::SCOPE_STORE);
    }

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_SUPERBUNDLE .'general/'. $code, $storeId);
    }



}