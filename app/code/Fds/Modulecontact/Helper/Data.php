<?php

/**
 * Fds_Modulecontact
 * Fds - fdallserra 2019
 * Helper:
 *    isEnable >> from Admin panel
 */

namespace Fds\Modulecontact\Helper;

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
            'contact/modulecontactgroup/enable', ScopeInterface::SCOPE_STORE
        );
    }





}
