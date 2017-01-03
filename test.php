<?php
namespace PMVC\PlugIn\dotenv;

use PMVC;
use PHPUnit_Framework_TestCase;

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
        $this->assertEquals($expected,$actual, "Simple Test");
        // test constent
        $this->assertEquals('fake_view', \PMVC\getoption(_VIEW_ENGINE), "Constent");
        $this->assertEquals('--"bar"--', \PMVC\getoption('foo'), "Escape double quote with single quote");
        $this->assertEquals('--"bar"--', \PMVC\getoption('foo1'), "Escape double quote with slash");
        $this->assertEquals('--bar--', \PMVC\getoption('foo2'), "Without escape double quot");
    }

    function testGetUnderscoreToArray()
    {
        # load dot file
        $actual = PMVC\plug('dotenv', [ESCAPE=>'\\'])
            ->getUnderscoreToArray('./.env.example');
        $expected = 'ddd';
        $this->assertEquals($expected,$actual['AAA']['BBB']['CCC']);
        $expected = 'eee';
        $this->assertEquals($expected,$actual['AAA_BBB_CCC']);
    }

}



