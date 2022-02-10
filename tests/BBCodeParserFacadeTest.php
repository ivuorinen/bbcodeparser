<?php

namespace ivuorinen\BBCode\Tests;

class BBCodeParserFacadeTest extends TestCase
{
    public function testFacadeExistsAndHasBbcode()
    {
        try {
            $method = $this->callMethod(
                new \ivuorinen\BBCode\Facades\BBCodeParser,
                'getFacadeAccessor',
                []
            );
            $this->assertEquals('bbcode', $method);
        } catch (ReflectionException $e) {
            $this->throwException($e);
        }
    }

    /**
     * @param $obj
     * @param $name
     * @param array $args
     * @return mixed
     * @throws ReflectionException
     */
    public static function callMethod($obj, $name, array $args)
    {
        $class = new \ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($obj, $args);
    }
}
