<?php
namespace PMVC\PlugIn\dotenv;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\dotenv';

const ENV_FILE = 'envFile';
const ENV_FOLDER = 'envFolder';
const ESCAPE = 'escape'; 

/**
 * @parameters string envFile ENV_FILE
 * @parameters string envFolder ENV_FOLDER
 * @parameters string escape if key start with escape will bypass underscore 
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
        if (empty($this[ENV_FOLDER]) && is_callable('\PMVC\getAppsParent')) {
            $this[ENV_FOLDER] = \PMVC\getAppsParent();
        }
    }

    public function initEnvFile()
    {
        $file = $this->fileExists($this[ENV_FILE]);
        if (!$file) {
            return !trigger_error(
                '[DotEnv:init] File not found. ['.$this[ENV_FILE].']',
                E_USER_WARNING
            );
        }
        if (empty($this[ENV_FOLDER])) {
            $this[ENV_FOLDER] = dirname($file);
        }
        $this->toPMVC($file);
    }

    public function toPMVC($file,$prefix='')
    {
        $arr = $this->getUnderscoreToArray($file);
        if (!is_array($arr)) {
            return false;
        }
        if (isset($arr['_'])) {
            $this->_processConstantArray($arr);
        }
        \PMVC\option('set', $arr);
    }

    /**
     * __VIEW_ENGINE='react'
     * replace to
     * constant('_VIEW_ENGINE') = 'react'
     */
    private function _processConstantArray(&$arr)
    {
        $_ = \PMVC\plug('underscore')
            ->array()
            ->toUnderscore($arr['_']);
        unset($arr['_']);
        foreach ($_ as $k=>$v) {
            $k = substr($k,1);
            if (defined($k)) {
                $k = constant($k);
            }
            $arr[$k] = $v;
        }
        return $arr;
    }

    public function processConstantArray($arr)
    {
        return $this->_processConstantArray($arr);
    }

    public function getUnderscoreToArray($file)
    {
        $arr = $this->getArray($file);
        if (!is_array($arr)) {
            return false;
        }
        return \PMVC\plug('underscore')
            ->underscore()
            ->toArray($arr, $this[ESCAPE]);
    }

    public function fileExists($file)
    {
        $realPath = \PMVC\realpath($file);
        if ($realPath) {
            return $realPath;
        } 
        $realPath = \PMVC\realpath(\PMVC\lastSlash($this[ENV_FOLDER]).$file);
        if ($realPath) {
            return $realPath;
        } 
        return false;
    }
    
    public function getArray($file)
    {
        $realPath = $this->fileExists($file);
        if (!$realPath) {
            return !trigger_error(
                '[DotEnv:getArray] File not found. ['.$file.']',
                E_USER_WARNING
            );
        }
        return parse_ini_string(file_get_contents($realPath), false);
    }
}
