<?php
namespace PMVC\PlugIn\dotenv;
${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\ParseIniString';

class ParseIniString {
    function __invoke($str) {
        
        if(empty($str)) return false;

        $lines = explode("\n", $str);
        $ret = [];

        foreach($lines as $line) {
            
            $line = trim($line);

            if(!$line || $line[0] == "#" || $line[0] == ";") continue;

            if(!strpos($line, '=')) continue;

            $tmp = explode("=", $line, 2);
                
                $key = trim($tmp[0]);
                $value = $this->parseValue($tmp[1]);
                preg_match("^\[(.*?)\]^", $key, $matches);
                if(!empty($matches) && isset($matches[0])) {

                    $arr_name = preg_replace('#\[(.*?)\]#is', '', $key);

                    if(!isset($ret[$arr_name]) || !is_array($ret[$arr_name])) {
                        $ret[$arr_name] = [];
                    }

                    if(isset($matches[1]) && !empty($matches[1])) {
                        $ret[$arr_name][$matches[1]] = $value;
                    } else {
                        $ret[$arr_name][] = $value;
                    }

                } else {
                    $ret[$key] = $value;
                }            

        }
        return $ret;
    }

    function parseValue($value)
    {
        $value = ltrim($value);
        if(preg_match("/^\".*\"$/", $value) || preg_match("/^'.*'$/", $value)) {
            $value = mb_substr($value, 1, mb_strlen($value) - 2);
        }
        return $value;
    }
}
