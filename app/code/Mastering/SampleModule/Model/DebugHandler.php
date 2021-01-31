<?php


namespace Mastering\SampleModule\Model;

use Monolog\Logger;
use Magento\Framework\Logger\Handler\Base;

//per usare un file diverso per i logs - il riferimento e' in di.xml


class DebugHandler extends Base
{
    /**
     * @var string
     */
    protected $fileName = '/var/log/debug_custom.log';

    /**
     * @var int
     */
    protected $loggerType = Logger::DEBUG;
}
