<?php

namespace Balise\Command;

use Symfony\Component\Console\Input\InputInterface;

class MakePostType extends Make
{

    protected $singular = 'post type';
    protected $plural = 'post types';
    protected $directory = 'post_type';

    protected $stub = 'customPostType.stub';


    public function setOptions()
    {
        $this->addOption('no_archive', false);
    }

    public function make(InputInterface $input, $name)
    {
        $no_archive = $input->getOption('no_archive');

        if (substr($name, -1) == 's') {
            $singular = ucfirst(substr($name, 0, -1));
            $plural = ucfirst($name);
        } else {
            $singular = ucfirst($name);
            $plural = ucfirst($name . 's');
        }
        $is_public = 'true';
        $has_archive = 'true';
        if ($no_archive) {
            $has_archive = 'false';
        }
        $this->stub_fields = [
            'dummy_post_type' => $name,
            'dummy_post_name' => ucfirst($name),
            'dummy_singular_name' => $singular,
            'dummy_plural_name' => $plural,
            'is_public' => $is_public,
            'post_has_archive' => $has_archive,
        ];

    }
}
