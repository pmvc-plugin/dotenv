<?php
PMVC\Load::plug();
PMVC\addPlugInFolder('../');

class DotEnvTest extends PHPUnit_Framework_TestCase
{
    function testToPMVC()
    {
        # load dot file
        PMVC\plug('dotenv')->toPMVC('./.env.example');
        $expected = 'bbb';
        $actual = \PMVC\getoption('aaa');
        $this->assertEquals($expected,$actual);
    }
}



