<?php


namespace Mastering\SampleModule\Console\Command;

use Magento\Framework\Event\ManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Mastering\SampleModule\Model\ItemFactory;
use Magento\Framework\Console\Cli;

/*Aggiunge il comando diretto da usare nella commandline con il Terminal
Aggiunge un item - Correlato poi al file di.xml
per verificare $bin/magento si vedono tutti i comandi possibili
lo si vede nella lista sotto 'mastering' = mastering:item:add
per chiamarlo:
$bin/magento mastering:item:add "Item 3" "Third description"
*/

class AddItem extends Command
{
    const INPUT_KEY_NAME = 'name';
    const INPUT_KEY_DESCRIPTION = 'description';

    private $itemFactory;
   // private $eventManager;

   // public function __construct(ItemFactory $itemFactory, ManagerInterface $eventManager)
    public function __construct(ItemFactory $itemFactory)
    {
        $this->itemFactory = $itemFactory;
       // $this->eventManager = $eventManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('mastering:item:add')
            ->addArgument(
                self::INPUT_KEY_NAME,
                InputArgument::REQUIRED,
                'Item name'
            )->addArgument(
                self::INPUT_KEY_DESCRIPTION,
                InputArgument::OPTIONAL,
                'Item description'
            );

        parent::configure();
    }

    //voglio creare plugin per questa funzione ma non si puo' perche' protected
    //Symfony\Component\Console\Command\Command ha pero' anche la funzione run
    //che e' public e' quella che uso nel Plugin Logger.php
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $item = $this->itemFactory->create();
        $item->setName($input->getArgument(self::INPUT_KEY_NAME));
        $item->setDescription($input->getArgument(self::INPUT_KEY_DESCRIPTION));
        $item->setIsObjectNew(true);
        $item->save();

        //l'observer will handle this event
     //   $this->eventManager->dispatch('mastering_command',['object' => $item]);
        //non serve piu' perche' automatico con l'eventPrefix

        return Cli::RETURN_SUCCESS;
    }

}
