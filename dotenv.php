<?php
/**
 * wrapper https://packagist.org/packages/josegonzalez/dotenv
 */
namespace PMVC\PlugIn\dotenv;

use josegonzalez\Dotenv\Loader as dot;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\dotenv';

class dotenv extends \PMVC\PlugIn
{
    const EnvFile = 'envFile';
    const EnvFolder = 'envFolder';
    public function init()
    {
        if ($this[self::EnvFile]) {
            $file = \PMVC\realpath($this[self::EnvFile]);
            if (!$this[self::EnvFolder] && $file) {
                $this[self::EnvFolder] = dirname($file); 
            }
            $this->toPMVC($file);
        }
    }

    public function toPMVC($file,$prefix='')
    {
        foreach ($this->getArray($file) as $k=>$v) {
            if (defined($k)) {
                $k = constant($k);
            }
            $k = $prefix.$k;
            \PMVC\option('set', $k, $v);
        }
    }
    
    public function getArray($file)
    {
        if (!\PMVC\realpath($file)) {
            $file = \PMVC\lastSlash($this[self::EnvFolder]).$file;
        }
        return (new dot($file))
            ->parse()
            ->toArray();
    }
}
