<?php


namespace Fds\FrancescaFront\App\Cache;

use Magento\Framework\App\Cache\Type\FrontendPool;
use Magento\Framework\Cache\Frontend\Decorator\TagScope;
use Magento\Framework\Config\CacheInterface;


class FrancescaCasc extends TagScope implements CacheInterface
{

    const TYPE_IDENTIFIER = 'francesca';
    const CACHE_TAG = 'FRANCESCA';

    public function __construct(FrontendPool $frontendPool)
    {
        parent::__construct($frontendPool->get(self::TYPE_IDENTIFIER), self::CACHE_TAG);
    }
}
