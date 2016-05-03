<?php
PMVC\Load::plug();
PMVC\addPlugInFolders(['../']);

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
    function testGetUnderscoreToArray()
    {
        # load dot file
        $actual = PMVC\plug('dotenv')->getUnderscoreToArray('./.env.example');
        $expected = 'ddd';
        $actual = $actual['AAA']['BBB']['CCC'];
        $this->assertEquals($expected,$actual);
    }
}



