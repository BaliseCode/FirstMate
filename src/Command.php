<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 18-11-14
 * Time: 15:35
 */

namespace Balise\Command;
use Symfony\Component\Console\Command\Command as SymfonyCommand;


class Command extends SymfonyCommand
{
    public function message($level, $message)
    {
        $this->output->writeln('<' . $level . '>' . $message . '</' . $level . '>');
    }
}
