<?php

namespace ivuorinen\BBCode\Tests;

class ArrayTraitTest extends TestCase
{
    private $class;

    public function setUp(): void
    {
        $this->class = new ArrayTraitHelper();
    }

    public function testArrayOnly(): void
    {
        $this->assertTrue(\method_exists($this->class, 'arrayOnly'));
    }

    public function testArrayExcept(): void
    {
        $this->assertTrue(\method_exists($this->class, 'arrayExcept'));
    }
}
