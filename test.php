<?php
PMVC\Load::plug();
PMVC\setPlugInFolder('../');

class DotEnvTest extends PHPUnit_Framework_TestCase
{
    function testToPMVC()
    {
        # load dot file
        PMVC\plug('dotenv')->toPMVC('./.env.example');
        $expected = 'bbb';
        $actual = getenv('aaa');
        $this->assertEquals($expected,$actual);
    }
}



