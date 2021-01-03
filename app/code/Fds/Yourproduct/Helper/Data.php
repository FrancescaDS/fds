<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 * Helper:
 *    isEnable >> from Admin panel
 *    default language code >> from Admin panel
 */

namespace Fds\Yourproduct\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{

    protected $context;

    public function __construct(Context $context)
    {
        $this->context = $context;
        parent::__construct($context);
    }

    public function isEnable()
    {
        return $this->scopeConfig->getValue(
            'yourproduct/general/enable', ScopeInterface::SCOPE_STORE
        );
    }





}
