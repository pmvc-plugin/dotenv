<?php
/**
 * wrapper https://packagist.org/packages/josegonzalez/dotenv
 */
namespace PMVC\PlugIn\dotenv;

use M1\Env\Parser;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\dotenv';

const EnvFolder = 'envFolder';

/**
 * @parameters string _env_file_ Global constent _ENV_FILE
 */
class dotenv extends \PMVC\PlugIn
{
    public function init()
    {
        if (isset($this[_ENV_FILE])) {
            $this->initEnvFile();
        } 
    }

    public function initEnvFile()
    {
        $file = \PMVC\realpath($this[_ENV_FILE]);
        if (!$this[EnvFolder] && $file) {
            $this[EnvFolder] = dirname($file); 
        }
        $this->toPMVC($file);
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

    public function getUnderscoreToArray($file)
    {
        $arr = $this->getArray($file);
        return \PMVC\plug('underscore')->underscore()->toArray($arr);
    }
    
    public function getArray($file)
    {
        if (!\PMVC\realpath($file)) {
            $file = \PMVC\lastSlash($this[EnvFolder]).$file;
        }
        return Parser::parse(file_get_contents($file));
    }
}
