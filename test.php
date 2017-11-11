<?php
namespace PMVC\PlugIn\dotenv;

use PMVC;
use PHPUnit_Framework_TestCase;

PMVC\Load::plug();
PMVC\addPlugInFolders(['../']);

class DotEnvTest extends PHPUnit_Framework_TestCase
{

    private $_plug = 'dotenv';

    function setup()
    {
        \PMVC\unplug($this->_plug);
    }

    function testToPMVC()
    {
        # load dot file
        $p = PMVC\plug($this->_plug, ['./.env.example']);
        $expected = 'bbb';
        $actual = \PMVC\getoption('aaa');
        // base test
        $this->assertEquals($expected, $actual, "Simple Test");
        $this->assertEquals(realpath('./'), $p[ENV_FOLDER], "Test env folder");

        // test constent
        $this->assertEquals('fake_view', \PMVC\getoption(_VIEW_ENGINE), "Constent");
        $this->assertEquals('not_constant', \PMVC\getoption('_not_constant'), "Constent not found");
        $this->assertEquals('--"bar"--', \PMVC\getoption('foo'), "Escape double quote with single quote");
        $this->assertEquals('--"bar"--', \PMVC\getoption('foo1'), "Escape double quote with slash");
        $this->assertEquals('--bar--', \PMVC\getoption('foo2'), "Without escape double quot");
    }

    function testGetUnderscoreToArray()
    {
        # load dot file
        $actual = PMVC\plug($this->_plug, [ESCAPE=>'\\'])
            ->getUnderscoreToArray('./.env.example');
        $expected = 'ddd';
        $this->assertEquals($expected,$actual['AAA']['BBB']['CCC']);
        $expected = 'eee';
        $this->assertEquals($expected,$actual['AAA_BBB_CCC']);
    }

    function testGetFolderWithParamZero()
    {
        $p = PMVC\plug($this->_plug, ['./']);
        $this->assertEquals(realpath('./'), $p[ENV_FOLDER]);
        $this->assertTrue(empty($p[ENV_FILE]));
    }
    
    function testGetEmptyArray()
    {
        $p = PMVC\plug($this->_plug);
        $arr = $p->getArray(null);
        $this->assertTrue(is_array($arr));
    }
}



