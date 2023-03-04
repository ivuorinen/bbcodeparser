<?php

namespace ivuorinen\BBCode\Tests;

use ivuorinen\BBCode\BBCodeParserServiceProvider;

class BBCodeParserServiceProviderTest extends TestCase
{
    public function testProvides(): void
    {
        $provider = new BBCodeParserServiceProvider($this->app);
        $this->assertEquals(['bbcode'], $provider->provides());
    }

    public function testRegister(): void
    {
        $this->assertInstanceOf(
            \ivuorinen\BBCode\BBCodeParser::class,
            $this->app['bbcode']
        );
    }
}
