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

    public function createDirectory()
    {
            @mkdir($this->dir,0755,true);
        return true;

    }
    public function createFile($origin, $dest, $stub_fields)
    {
        $stub = file_get_contents($origin);
        foreach ($stub_fields as $key => $field) {
            $stub = str_replace($key, $field, $stub);
        }
        return !(file_put_contents($dest, $stub)===false);
    }
}
