<?php


namespace Fds\FirstModule\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class LogTextAtCheckout implements ObserverInterface
{

    public function execute(Observer $observer)
    {
        // print Out some text in the log/test.log
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('Your text message');

    }
}
