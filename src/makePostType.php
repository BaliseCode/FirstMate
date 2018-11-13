<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 18-11-13
 * Time: 11:11
 */

namespace Balise\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class makePostType extends Command
{
    public function configure()
    {
        $this->setName('makePostType')
            ->setDescription('Create a Post Type boilerplate.')
            ->addArgument('name', InputArgument::REQUIRED, 'Your Name.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
       $output->writeln('Allo toi');
    }
}