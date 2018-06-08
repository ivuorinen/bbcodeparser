<?php

namespace ivuorinen\BBCode\Tests;

use ArrayTraitHelper;
use TestCase;

class ArrayTraitTest extends TestCase
{
    private $class;

    public function setUp()
    {
        $this->class = new ArrayTraitHelper();
    }

    public function test_array_only()
    {
        $this->assertTrue(\method_exists($this->class, 'arrayOnly'));
    }

    public function test_array_except()
    {
        $this->assertTrue(\method_exists($this->class, 'arrayExcept'));
    }
}
