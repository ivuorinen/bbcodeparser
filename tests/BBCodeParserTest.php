<?php

namespace ivuorinen\BBCode\Tests;

use ivuorinen\BBCode\BBCodeParser;

class BBCodeParserTest extends TestCase
{
    /** @var \ivuorinen\BBCode\BBCodeParser $parser */
    private $parser;

    /**
     * @var array These are harder to test, so we postponed them.
     */
    public $skipParsers = array();

    /**
     * @see \ivuorinen\BBCode\BBCodeParser::$parsers
     * @var array[] Easier to maintain basic tests
     */
    public $testedParsers = array(
        'bold' => array(
            'bbcode' => 'b',
            'expected' => 'strong',
        ),
        'italic' => array(
            'bbcode' => 'i',
            'expected' => 'em',
        ),
        'underline' => array(
            'bbcode' => 'u'
        ),
        'linethrough' => array(
            'bbcode' => 'u'
        ),
        'size' => array(
            'bbcode_test' => '[size=%s]%s[/size]',
            'expected_test' => '<font size="%s">%s</font>',
            'values' => ['1', 'text']
        ),
        'color' => array(
            'bbcode_test' => '[color=%s]%s[/color]',
            'expected_test' => '<font color="%s">%s</font>',
            'values' => ['#123456', 'color']
        ),
        'center' => array(
            'bbcode' => 'center',
            'expected_test' => '<div style="text-align:center;">%s</div>',
            'values' => ['center aligned']
        ),
        'left' => array(
            'bbcode' => 'left',
            'expected_test' => '<div style="text-align:left;">%s</div>',
            'values' => ['left aligned']
        ),
        'right' => array(
            'bbcode' => 'right',
            'expected_test' => '<div style="text-align:right;">%s</div>',
            'values' => ['right aligned']
        ),
        'quote' => array(
            'bbcode' => 'quote',
            'expected_test' => '<blockquote>%s</blockquote>',
            'values' => ['quotable text']
        ),
        'namedquote' => array(
            'bbcode_test' => '[quote=%s]%s[/quote]',
            'expected_test' => '<blockquote><small>%s</small>%s</blockquote>',
            'values' => ['name', 'quotable text']
        ),
        'link' => array(
            'bbcode' => 'url',
            'bbcode_test' => '[url]%s[/url]',
            'expected_test' => '<a href="%1$s">%1$s</a>',
            'values' => ['value']
        ),
        'namedlink' => array(
            'bbcode' => 'url',
            'bbcode_test' => '[url=%s]%s[/url]',
            'expected_test' => '<a href="%s">%s</a>',
            'values' => ['link', 'value']
        ),
        'image' => array(
            'bbcode' => 'img',
            'expected_test' => '<img src="%s">',
            'values' => ['link']
        ),
        'linebreak' => array(
            'bbcode_test' => "\r\n",
            'expected_test' => '<br />'
        ),
        'code' => array(
            'bbcode' => 'code',
            'values' => ['link']
        ),
        'youtube' => array(
            'bbcode' => 'youtube',
            'expected_test' => '<iframe width="560" height="315" src="//www.youtube.com/embed/%s"' .
                ' frameborder="0" allowfullscreen></iframe>',
            'values' => ['dQw4w9WgXcQ']
        ),
        'listitem' => array(
            'bbcode_test' => "[*] List item",
            'expected_test' => '<li> List item</li>'
        ),
        'orderedlistnumerical' => array(
            'bbcode' => 'list',
            'bbcode_test' => '[list=1]%s[/list]',
            'expected_test' => '<ol>%s</ol>',
            'values' => ['X']
        ),
        'orderedlistalpha' => array(
            'bbcode' => 'list',
            'bbcode_test' => '[list=a]%s[/list]',
            'expected_test' => '<ol type="a">%s</ol>',
            'values' => ['X']
        ),
        'unorderedlist' => array(
            'bbcode' => 'list',
            'bbcode_test' => '[list]%s[/list]',
            'expected_test' => '<ul>%s</ul>',
            'values' => ['X']
        ),
    );

    public $lowerCaseTests = array(
        ['bbcode' => '[code]Result[/code]', 'expected' => '<code>Result</code>'],
        ['bbcode' => '[i]Result[/i]', 'expected' => '<em>Result</em>'],
    );

    public $upperCaseTests = array(
        ['bbcode' => '[CODE]Result[/CODE]', 'expected' => '<code>Result</code>'],
        ['bbcode' => '[I]Result[/I]', 'expected' => '<em>Result</em>'],
    );

    public $mixedCaseTests = array(
        ['bbcode' => '[Code]Result[/Code]', 'expected' => '<code>Result</code>'],
        ['bbcode' => '[I]Result[/i]', 'expected' => '<em>Result</em>'],
    );

    protected function setUp(): void
    {
        $this->parser = new BBCodeParser();
        parent::setUp();
    }

    public function testItHasKnownParsers(): void
    {
        $this->assertEquals(
            $this->parser->parsers,
            $this->parser->getParsers()
        );
    }

    public function testParsersHaveRequiredKeys(): void
    {
        $keys = ['pattern', 'replace', 'content'];
        $parsers = $this->parser->getParsers();

        foreach ($parsers as $parserName => $parser) {
            foreach ($keys as $key) {
                $this->assertTrue(
                    array_key_exists($key, $parser),
                    sprintf('Parser: %s, Key: %s', $parserName, $key)
                );
            }
        }
    }

    public function testParserRegexpIsValid(): void
    {
        $parsers = $this->parser->getParsers();
        foreach ($parsers as $parserName => $parser) {
            $pattern = $parser['pattern'];

            $this->assertTrue(
                $this->assertRegexpIsValid($pattern),
                sprintf('Key: %s, Regexp %s', $parserName, $pattern)
            );
        }
    }

    public function testParserDefault(): void
    {
        foreach ($this->testedParsers as $name => $options) {
            $test = $this->createTest($options, $name);

            $result = $this->parser->parse($test['bbcode_test']);
            $this->assertEquals($test['expected_test'], $result, $name);
        }
    }

    public function testParserSensitive(): void
    {
        $testTemp = 'Test: %s / bbcode: %s / Actual: %s / Expected: %s';

        /**
         * We expect these to pass
         * Using: assertEquals
         */
        foreach ($this->lowerCaseTests as $case) {
            $bbcode = $case['bbcode'];
            $expected = $case['expected'];

            $result = $this->parser->parseCaseSensitive($bbcode);
            $this->assertEquals($expected, $result, sprintf(
                $testTemp,
                'lowercase, sensitive',
                $bbcode,
                $result,
                $expected
            ));
        }

        /**
         * We expect these to fail
         * Using: assertNotEquals
         */
        foreach ($this->upperCaseTests as $case) {
            $bbcode = $case['bbcode'];
            $expected = $case['expected'];

            $result = $this->parser->parseCaseSensitive($bbcode);
            $this->assertNotEquals($expected, $result, sprintf(
                $testTemp,
                'uppercase, sensitive',
                $bbcode,
                $result,
                $expected
            ));
        }

        /**
         * We expect these to fail
         * Using: assertNotEquals
         */
        foreach ($this->mixedCaseTests as $case) {
            $bbcode = $case['bbcode'];
            $expected = $case['expected'];

            $result = $this->parser->parseCaseSensitive($bbcode);
            $this->assertNotEquals($expected, $result, sprintf(
                $testTemp,
                'mixed case, sensitive',
                $bbcode,
                $result,
                $expected
            ));
        }
    }

    public function testParserInsensitive(): void
    {
        /**
         * Now we run with insensitive case turned on, so everything
         * should pass -- why this is not the default in original
         * package baffles me.
         */
        $cases = array_merge(
            $this->lowerCaseTests,
            $this->upperCaseTests,
            $this->mixedCaseTests
        );

        foreach ($cases as $case) {
            $bbcode = $case['bbcode'];
            $expected = $case['expected'];
            $this->assertEquals(
                $expected,
                $this->parser->parse($bbcode, true)
            );

            $this->assertEquals(
                $expected,
                $this->parser->parseCaseInsensitive($bbcode)
            );
        }
    }

    public function testStripBBCodeTags(): void
    {
        foreach ($this->mixedCaseTests as $test) {
            $this->assertEquals(
                \strip_tags($test['expected']),
                $this->parser->stripBBCodeTags($test['bbcode'])
            );
        }
    }

    public function testOnly(): void
    {
        $keys = array('bold', 'underline');

        $parsers = $this->parser->getParsers();
        $onlyFew = $this->parser->only($keys)->getParsers();

        $this->assertEquals($keys, array_keys($onlyFew));
        $this->assertNotEquals(array_keys($parsers), array_keys($onlyFew));
    }

    public function testExcept(): void
    {
        $keys = array('bold', 'underline');

        $parsers = $this->parser->getParsers();
        $exceptFew = $this->parser->except($keys)->getParsers();

        $this->assertNotEquals($keys, array_keys($exceptFew));
        $this->assertNotEquals(array_keys($parsers), array_keys($exceptFew));
    }

    public function testAddingNewParser(): void
    {
        $this->parser->setParser('test', 'x', 'y', 'z');
        $expected = array('pattern' => 'x', 'replace' => 'y', 'content' => 'z');
        $parsers = $this->parser->getParsers();

        $this->assertArrayHasKey('test', $parsers);
        foreach ($expected as $key => $value) {
            $this->assertTrue(array_key_exists($key, $parsers['test']));
            $this->assertEquals($value, $parsers['test'][$key]);
        }
    }

    public function testWeHaveAllParsersTested(): void
    {
        $parsers = array_keys($this->parser->except($this->skipParsers)->getParsers());
        $missing = array();

        foreach ($parsers as $parser) {
            $result = isset($this->testedParsers[$parser]);

            if ($result) {
                $this->assertTrue($result, sprintf('Parser missing: %s', $parser));
            }

            if (!$result) {
                $missing[$parser] = $parser;
            }
        }

        if (!empty($missing)) {
            $missing = sprintf(
                'Missing tests: %s',
                implode(", ", $missing)
            );
            $this->markTestIncomplete($missing);
        }
    }

    /**
     * This is a helper to use our self::testedParsers
     * rules for automated test generation. Automation ftw.
     *
     * @param array $options
     * @param string $name
     * @return array
     */
    public function createTest($options = [], $name = ''): array
    {
        if (!isset($options['bbcode'])) {
            $options['bbcode'] = $name;
        }

        if (!isset($options['values']) || empty($options['values'])) {
            $options['values'] = ['Testing'];
        }

        if (!isset($options['bbcode_test'])) {
            $bbcodeValues = $options['values'];
            array_unshift($bbcodeValues, $options['bbcode']);
            array_push($bbcodeValues, $options['bbcode']);
            $options['bbcode_test'] = vsprintf('[%s]%s[/%s]', $bbcodeValues);
        } else {
            $options['bbcode_test'] = vsprintf($options['bbcode_test'], $options['values']);
        }

        if (!isset($options['expected'])) {
            $options['expected'] = $options['bbcode'];
        }

        if (!isset($options['expected_test'])) {
            $expectedValues = $options['values'];
            array_unshift($expectedValues, $options['expected']);
            array_push($expectedValues, $options['expected']);
            $options['expected_test'] = vsprintf('<%s>%s</%s>', $expectedValues);
        } else {
            $options['expected_test'] = vsprintf($options['expected_test'], $options['values']);
        }

        return $options;
    }
}
