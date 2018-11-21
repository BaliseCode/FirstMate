<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 18-11-21
 * Time: 10:02
 */

namespace Balise\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

abstract class Make extends Command
{
    protected $singular;
    protected $plural;
    protected $directory;
    protected $stub_file;
    protected $stub_fields;
    protected $stub;
    private $path;

    abstract public function make(InputInterface $input, $name);
    abstract public function setOptions();


    public function __construct($name = null)
    {
        $this->stub_file = __dir__ . '/stubs/' . $this->stub;
        parent::__construct($name);
    }

    public function configure()
    {
        $this->setName('make:' . str_replace(' ', '-', $this->singular))
            ->setDescription('Create a ' . $this->singular . ' boilerplate.')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the '. $this->singular);
        $this->setOptions();
    }

    public function createDirectory()
    {
        $this->path = THEME_DIR . $this->directory;
        if(!file_exists($this->path)) {
            return mkdir($this->path, 0755, true);
        } else {
            return true;
        }
    }

    /**
     * @param $origin
     * @param $dest
     * @param $stub_fields
     * @return bool
     */
    public function createFile($origin, $dest, $stub_fields)
    {
        $stub = file_get_contents($origin);
        foreach ($stub_fields as $key => $field) {
            $stub = str_replace($key, $field, $stub);
        }
        return !(file_put_contents($dest, $stub) === false);
    }

    public function runCommand(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        if (!$this->createDirectory()) {
            $this->message('error', 'An error occured while trying to create the '. $this->plural .' directory. Please check directory permission.');
            return;
        }

        $this->make($input, $name);

        if (is_file($this->path . '/' . $name . '.php')) {
            $helper = $this->getHelper('question');
            $question = new ConfirmationQuestion('Seems that the '. $this->singular . ' already exists. Overwrite it? (n/y) ', false);
            if (!$helper->ask($input, $output, $question)) {
                $this->message('info', 'Command cancelled!!');
                return;
            }
        }

        if ($this->createFile(
            $this->stub_file,
            $this->path . '/' . $name . '.php',
            $this->stub_fields
        )) {
            $this->message('info', 'The '. $this->singular .' was successfully created!');
        } else {
            $this->message('error', 'An error occured while trying to create the '. $this->singular .' file. Please check directory permission.');
        }

    }

}