<?php


namespace Fds\FirstModule\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloWorldCommand
{
    public function __construct($name = null)
    {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('zzzz:hello_world2')
            ->setDescription('Hello world');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello world!');
    }
}
