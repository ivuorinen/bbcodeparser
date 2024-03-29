[![Latest Version](https://img.shields.io/github/release/ivuorinen/bbcodeparser.svg?style=flat-square)](https://github.com/ivuorinen/bbcodeparser/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/ivuorinen/bbcodeparser/master.svg?style=flat-square)](https://travis-ci.org/ivuorinen/bbcodeparser)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/ivuorinen/bbcodeparser/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/ivuorinen/bbcodeparser/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/ivuorinen/bbcodeparser/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/ivuorinen/bbcodeparser)
[![Total Downloads](https://img.shields.io/packagist/dt/ivuorinen/bbcodeparser.svg?style=flat-square)](https://packagist.org/packages/ivuorinen/bbcodeparser)

The `ivuorinen\BBCodeParser` package will help you with parsing BBCode.
This package is build on work by [Joseph Landberg](https://github.com/golonka).

## Install

Via Composer

```
composer require ivuorinen/bbcodeparser
```

## Usage

To parse some text it's as easy as this!

```php
$bbcode = new ivuorinen\BBCode\BBCodeParser();

echo $bbcode->parse('[b]Bold Text![/b]');
// <strong>Bold Text!</strong>
```

Would like the parser to not use all bbcodes? Just do like this.

```php
$bbcode = new ivuorinen\BBCode\BBCodeParser();

echo $bbcode
    ->only('bold', 'italic')
    ->parse('[b][u]Bold[/u] [i]Italic[/i]![/b]'); // <strong>[u]Bold[/u] <em>Italic</em>!</strong>

echo $bbcode
    ->except('bold')
    ->parse('[b]Bold[/b] [i]Italic[/i]'); // [b]Bold[/b] <em>Italic</em>
```

By default, the parser is case-sensitive. But if you would like the parser
to accept tags like `[B]Bold Text[/B]` it's really easy.

```php
$bbcode = new ivuorinen\BBCode\BBCodeParser();

// Case insensitive
echo $bbcode->parse('[b]Bold[/b] [I]Italic![/I]', true); // <strong>Bold</strong> <em>Italic!</em>

// Or like this:
echo $bbcode->parseCaseInsensitive('[b]Bold[/b] [i]Italic[/i]'); // <strong>Bold</strong> <em>Italic!</em>
```

You could also make it more explicit that the parser is case-sensitive by using another helper function.

```php
$bbcode = new ivuorinen\BBCode\BBCodeParser();

echo $bbcode->parseCaseSensitive('[b]Bold[/b] [I]Italic![/I]'); // <strong>Bold</strong> [I]Italic![/I]
```

If you would like to completely remove all BBCode it's just one function call away.

```php
$bbcode = new ivuorinen\BBCode\BBCodeParser();

echo $bbcode->stripBBCodeTags('[b]Bold[/b] [i]Italic![/i]'); // Bold Italic!
```

## Laravel integration

The integration into Laravel is really easy, and the method is the same for both Laravel 4 and Laravel 5.
This package supports Laravel Package Auto-Discovery, so it should be picked up automatically.

If you don't want auto-discovery, or because of old habits, just open your ``app.php`` config file.

In there you just add this to your providers array

```php
'ivuorinen\BBCode\BBCodeParserServiceProvider'
```

And this to your facades array

```php
'BBCode' => 'ivuorinen\BBCode\Facades\BBCodeParser'
```

The syntax is the same as if you would use it in vanilla PHP but with the ``BBCode::`` before the methods.
Here are some examples.

```php
// Simple parsing
echo BBCode::parse('[b]Bold Text![/b]');

// Limiting the parsers with the only method
echo BBCode::only('bold', 'italic')
        ->parse('[b][u]Bold[/u] [i]Italic[/i]![/b]'); // <strong>[u]Bold[/u] <em>Italic</em>!</strong>

// Or the except method
echo BBCode::except('bold')
        ->parse('[b]Bold[/b] [i]Italic[/i]'); // [b]Bold[/b] <em>Italic</em>
```

## Testing

``` bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Ismo Vuorinen](https://github.com/ivuorinen)
- [Joseph Landberg](https://github.com/golonka)
- [All Contributors](https://github.com/ivuorinen/bbcodeparser/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
