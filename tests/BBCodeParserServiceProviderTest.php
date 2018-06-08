<?php

use ivuorinen\BBCode\BBCodeParserServiceProvider;

class BBCodeParserServiceProviderTest extends TestCase
{
    public function testProvides()
    {
        $provider = new BBCodeParserServiceProvider($this->app);
        $this->assertEquals(['bbcode'], $provider->provides());
    }

    public function testRegister()
    {
        $this->assertInstanceOf(
            \ivuorinen\BBCode\BBCodeParser::class,
            $this->app['bbcode']
        );
    }
}
