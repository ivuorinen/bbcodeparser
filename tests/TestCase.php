<?php

namespace ivuorinen\BBCode\Tests;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        unset($app);
        return ['ivuorinen\BBCode\BBCodeParserServiceProvider'];
    }

    protected function assertRegexpIsValid(string $pattern = ''): bool
    {
        if (@preg_match($pattern, '') === false) {
            return false;
        }
        return true;
    }
}
