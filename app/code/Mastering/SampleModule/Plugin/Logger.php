<?php


namespace Mastering\SampleModule\Plugin;

use Mastering\SampleModule\Console\Command\AddItem;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

//configurazione in di.xml
//chiamando
//$ bin/magento mastering:item:add "customnameplugin" "thesummaryx description"
//si vede:
//beforeExecute
//aroundExecute before call
//aroundExecute after call
//afterExecute
class Logger
{
    /**
     * @var OutputInterface
     */
    private $output;

    public function beforeRun(
        AddItem $command,
        InputInterface $input,
        OutputInterface $output
    ) {
        $output->writeln('beforeExecute');
    }

    //AROUND is executed instead of the method
    //chiamando closure si invoca the original method execution
    public function aroundRun(
        AddItem $command,
        \Closure $proceed,
        InputInterface $input,
        OutputInterface $output
    ) {
        $output->writeln('aroundExecute before call');
        //call to the original run method
        $proceed->call($command, $input, $output);
        $output->writeln('aroundExecute after call');
        $this->output = $output;
    }

    public function afterRun(AddItem $command)
    {
        $this->output->writeln('afterExecute');
    }
}
