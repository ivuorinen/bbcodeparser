<?php

class TestCase extends Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return ['ivuorinen\BBCode\BBCodeParserServiceProvider'];
    }

    /**
     * @param string $pattern
     * @return bool
     */
    protected function assertRegexpIsValid($pattern = '')
    {
        if (@preg_match($pattern, null) === false) {
            return false;
        }
        return true;
    }
}
