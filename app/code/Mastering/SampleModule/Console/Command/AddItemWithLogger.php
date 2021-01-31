<?php


namespace Mastering\SampleModule\Console\Command;

use Psr\Log\LoggerInterface;
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

class AddItemWithLogger extends Command
{
    const INPUT_KEY_NAME = 'name';
    const INPUT_KEY_DESCRIPTION = 'description';

    private $itemFactory;
    private $logger;

    public function __construct(ItemFactory $itemFactory, \Psr\Log\LoggerInterface $logger)
    {
        $this->itemFactory = $itemFactory;
        $this->logger = $logger;
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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $item = $this->itemFactory->create();
        $item->setName($input->getArgument(self::INPUT_KEY_NAME));
        $item->setDescription($input->getArgument(self::INPUT_KEY_DESCRIPTION));
        $item->setIsObjectNew(true);
        $item->save();

        $this->logger->debug('Item was created');

        return Cli::RETURN_SUCCESS;
    }

}
