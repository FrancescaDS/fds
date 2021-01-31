<?php


namespace Mastering\SampleModule\Cron;

use Mastering\SampleModule\Model\ItemFactory;
use Mastering\SampleModule\Model\Config;

/* Per eseguirlo by schedule bisogna metterla nel file crontab.xml  */
/*Bisogna farlo partire con $bin/magento cron:run
aggiunge questa schedule to the list af all in table cron_scheduled
*/

class AddItem
{
    private $itemFactory;
    private $config;

    public function __construct(ItemFactory $itemFactory, Config $config)
    {
        $this->itemFactory = $itemFactory;
        $this->config = $config;
    }

    public function execute()
    {
        if ($this->config->isEnabled()){
            $this->itemFactory->create()
                ->setName('Scheduled item')
                ->setDescription('Created at bis ' . time())
                ->save();
        }
    }
}
