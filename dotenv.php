<?php
/**
 * wrapper https://packagist.org/packages/josegonzalez/dotenv
 */
namespace PMVC\PlugIn\dotenv;

use josegonzalez\Dotenv\Loader as dot;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\dotenv';

class dotenv extends \PMVC\PlugIn
{
    public function init()
    {
        $key = 'envfile';
        if ($this[$key]) {
            $this->toPMVC($this[$key]);
        }
    }

    public function toPMVC($file)
    {
        $configs = (new dot($file))
            ->parse()
            ->toArray();
        foreach ($configs as $k=>$v) {
            if (defined($k)) {
                $k = constant($k);
            }
            \PMVC\option('set', $k, $v);
        }
    }
}
