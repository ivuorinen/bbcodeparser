<?php

namespace ivuorinen\BBCode\Tests;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use ArraySubsetAsserts;

    protected function getPackageProviders($app)
    {
        unset($app);
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
