<?php
/**
 * wrapper https://packagist.org/packages/josegonzalez/dotenv
 */
namespace PMVC\PlugIn\dotenv;

use josegonzalez\Dotenv\Loader as dot;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\dotenv';

class dotenv extends \PMVC\PlugIn
{
    public function toPMVC($file)
    {
        $configs = (new dot($file))
            ->parse()
            ->toArray();
        \PMVC\option('set', $configs);
    }
}
