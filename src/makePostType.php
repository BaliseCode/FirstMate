<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 18-11-13
 * Time: 11:11
 */

namespace Balise\Command;


use Balise\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class makePostType extends Command
{
    private $base_dir;
    private $cpt_dir;

    /**
     * The output interface implementation.
     *
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    public $output;


    public function __construct()
    {
        $this->base_dir = THEME;
        $this->cpt_dir = $this->base_dir . '/custom_post_type';
        parent::__construct();
    }
    
    private function createDirectory()
    {
        $dir = $this->cpt_dir;
        if (!is_dir($dir)) {
            if (!mkdir($dir)) {
                return false;
            }
        }
        return true;

    }

    private function createFile($stub_fields)
    {
        $stub = file_get_contents(__DIR__ . '/stubs/customPostType.stub');

        if (defined('TEXT_DOMAIN')) {
            $stub_fields['dummy_text_domain'] = ", '" . TEXT_DOMAIN . "'";
        } else {
            $stub_fields['dummy_text_domain'] = '';
        }
        foreach ($stub_fields as $key => $field) {
            $stub = str_replace($key, $field, $stub);
        }

        return file_put_contents($this->cpt_dir . '/' . $stub_fields['dummy_post_type'] . '.php', $stub);
    }


    public function configure()
    {
        $this->setName('makePostType')
            ->setDescription('Create a Post Type boilerplate.')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the custom post type.')
            ->addOption('no_archive', false);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $no_archive = $input->getOption('no_archive');

        $this->output = $output;

        if (!$this->createDirectory()) {
            $this->message('error', 'An error occured while trying to create the custom_post_type directory. Please check directory permission.');
            return;
        }

        if (is_file($this->cpt_dir . '/' . $name . '.php')) {
            $helper = $this->getHelper('question');
            $question = new ConfirmationQuestion('Seems that the custom post type already exists. Overwrite it? (n/y)', false);
            if (!$helper->ask($input, $output, $question)) {
                $this->message('info', 'Command cancelled!!');
                return;
            }
        }


        if (substr($name, -1) == 's') {
            $singular = ucfirst(substr($name, 0, -1));
        } else {
            $singular = ucfirst($name);
        }

        $is_public = 'true';
        $has_archive = 'true';
        if($no_archive) {
            $has_archive = 'false';
        }

        $stub_fields = [
            'dummy_post_type' => $name,
            'dummy_post_name' => ucfirst($name),
            'dummy_singular_name' => $singular,
            'is_public' => $is_public,
            'post_has_archive' => $has_archive
        ];

        if ($this->createFile($stub_fields)) {
            $this->message('info', 'The custom post type was successfully created!');
        } else {
            $this->message('error', 'An error occured while trying to create the custom_post_type file. Please check directory permission.');
        }
    }
}