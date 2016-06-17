<?php
/**
 * wrapper https://packagist.org/packages/josegonzalez/dotenv
 */
namespace PMVC\PlugIn\dotenv;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\dotenv';

const ENV_FILE = 'envFile';
const ENV_FOLDER = 'envFolder';

/**
 * @parameters string envFile ENV_FILE
 * @parameters string envFolder ENV_FOLDER
 */
class dotenv extends \PMVC\PlugIn
{
    public function init()
    {
        if (isset($this[0])) {
            $this[ENV_FILE] = $this[0];
            unset($this[0]);
        }
        if (isset($this[ENV_FILE])) {
            $this->initEnvFile();
        } 
    }

    public function initEnvFile()
    {
        $file = \PMVC\realpath($this[ENV_FILE]);
        if (!$this[ENV_FOLDER] && $file) {
            $this[ENV_FOLDER] = dirname($file);
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

    public function fileExists($file)
    {
        return \PMVC\realpath(\PMVC\lastSlash($this[ENV_FOLDER]).$file);
    }
    
    public function getArray($file)
    {
        if (!\PMVC\realpath($file)) {
            $file = $this->fileExists($file);
        }
        return parse_ini_string(file_get_contents($file), false);
    }
}
