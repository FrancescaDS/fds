<?php


namespace Fds\FirstModule\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloWorld extends Command
{
    //NON FUNZIONA
    public function configure()
    {
        $this->setName('ztraining:hello_world')
            ->setDescription('the command print out hello world')
            ->setAliases(array('hw'));
        $this->setDefinition([
            new InputArgument("name", InputArgument::OPTIONAL, 'the name of the person', null, null)
        ]);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello world, ' . $input->getArgument('name'));
    }
}
