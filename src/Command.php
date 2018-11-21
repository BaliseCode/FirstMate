<?php
/**
* Created by PhpStorm.
* User: francis
* Date: 18-11-14
* Time: 15:35
*/

namespace Balise\Command;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


abstract class Command extends SymfonyCommand
{

    /**
     * @var $output OutputInterface
     */
    private $output;

    abstract public function runCommand(InputInterface $input, OutputInterface $output);

    public function message($level, $message)
    {
        $this->output->writeln('<' . $level . '>' . $message . '</' . $level . '>');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->runCommand($input, $output);
    }
}
