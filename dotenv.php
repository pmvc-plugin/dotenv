<?php
/**
 * wrapper https://packagist.org/packages/josegonzalez/dotenv
 */
namespace PMVC\PlugIn\dotenv;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\dotenv';

const ENV_FILE = 'envFile';
const ENV_FOLDER = 'envFolder';

/**
 * @parameters string envFile
 * @parameters string envFolder
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
    
    public function getArray($file)
    {
        if (!\PMVC\realpath($file)) {
            $file = \PMVC\lastSlash($this[ENV_FOLDER]).$file;
        }
        return parse_ini_string(file_get_contents($file), true);
    }
}
