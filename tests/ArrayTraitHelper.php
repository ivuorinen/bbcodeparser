<?php

namespace ivuorinen\BBCode\Tests;

use ivuorinen\BBCode\Traits\ArrayTrait;

class ArrayTraitHelper
{
    use ArrayTrait;

    /**
     * @param array $parsers
     * @param $only
     * @see \ivuorinen\BBCode\Traits\ArrayTrait::arrayOnly
     * @return array
     */
    public function publicArrayOnly(array $parsers, $only)
    {
        return $this->arrayOnly($parsers, $only);
    }

    /**
     * @param array $parsers
     * @param $except
     * @see \ivuorinen\BBCode\Traits\ArrayTrait::arrayExcept
     * @return array
     */
    public function publicArrayExcept(array $parsers, $except)
    {
        return $this->arrayExcept($parsers, $except);
    }
}
