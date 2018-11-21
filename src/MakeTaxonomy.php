<?php
/**
* Created by PhpStorm.
* User: francis
* Date: 18-11-13
* Time: 11:11
*/

namespace Balise\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;


class MakeTaxonomy extends Make {

    protected $singular = 'taxomomy';
    protected $plural = 'taxonomies';
    protected $directory = 'taxonomies';

    protected $stub = 'taxonomy.stub';

    public function setOptions()
    {
        $this->addOption('no_archive', false);
    }

    public function make(InputInterface $input, $name)
    {
        $no_archive = $input->getOption('no_archive');

        if (substr($name, -1) == 's') {
            $singular = ucfirst(substr($name, 0, -1));
            $plural   = ucfirst($name);
        } else {
            $singular = ucfirst($name);
            $plural   = ucfirst($name . 's');
        }
        $is_public   = 'true';
        $has_archive = 'true';
        if ($no_archive) {
            $has_archive = 'false';
        }
        $this->stub_fields = [
            'dummy_post_type'     => $name,
            'dummy_post_name'     => ucfirst($name),
            'Dummy_singular_name' => $singular,
            'Dummy_plural_name'   => $plural,
            'is_public'           => $is_public,
            'post_has_archive'    => $has_archive,
        ];

    }
}
