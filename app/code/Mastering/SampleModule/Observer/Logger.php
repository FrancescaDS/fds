<?php


namespace Mastering\SampleModule\Observer;

use Psr\Log\LoggerInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Logger implements ObserverInterface
{

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        //scrive nel log il nome del item appena creato con la command line
        $this->logger->debug(
            $observer->getEvent()->getObject()->getName()
        );
    }
}
