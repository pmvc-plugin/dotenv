<?php
/**
 * wrapper https://packagist.org/packages/josegonzalez/dotenv
 */
namespace PMVC\PlugIn\dotenv;

use josegonzalez\Dotenv\Loader as dot;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\dotenv';

const EnvFile = 'envFile';
const EnvFolder = 'envFolder';

class dotenv extends \PMVC\PlugIn
{
    public function init()
    {
        if ($this[EnvFile]) {
            $file = \PMVC\realpath($this[EnvFile]);
            if (!$this[EnvFolder] && $file) {
                $this[EnvFolder] = dirname($file); 
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

    public function getUnderscoreToArray($file)
    {
        $arr = $this->getArray($file);
        $new = [];
        foreach($arr as $k=>$v) {
            $keys = explode('_',$k);
            $str = ''; 
            foreach($keys as $k1) {
               if (empty($str)) {
                   $str = $k1;
               }else{
                   $str .= '['.$k1.']'; 
               }   
            }   
            $str.='='.$v;
            parse_str($str,$new1);
            $new = array_merge_recursive($new,$new1);
        }
        return $new;
    }
    
    public function getArray($file)
    {
        if (!\PMVC\realpath($file)) {
            $file = \PMVC\lastSlash($this[EnvFolder]).$file;
        }
        return (new dot($file))
            ->parse()
            ->toArray();
    }
}
