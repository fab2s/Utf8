# Utf8

[![Build Status](https://travis-ci.com/fab2s/Utf8.svg?branch=master)](https://travis-ci.com/fab2s/Utf8) [![Total Downloads](https://poser.pugx.org/fab2s/utf8/downloads)](//packagist.org/packages/fab2s/utf8) [![Monthly Downloads](https://poser.pugx.org/fab2s/utf8/d/monthly)](//packagist.org/packages/fab2s/utf8) [![Latest Stable Version](https://poser.pugx.org/fab2s/utf8/v/stable)](https://packagist.org/packages/fab2s/utf8) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/fab2s/Utf8/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/fab2s/Utf8/?branch=master) [![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg?style=flat)](http://makeapullrequest.com) [![License](https://poser.pugx.org/fab2s/utf8/license)](https://packagist.org/packages/fab2s/utf8)

A purely static UTF-8 Helper based on [mb_string](https://php.net/mb_string) and [ext-intl](https://php.net/intl)

> For sure this is not new, and there is better out there, but this is small and does the job without a lot of noise

## Installation

`Utf8` can be installed using composer:

```
composer require "fab2s/utf8"
```

`Utf8` is also included in [OpinHelper](https://github.com/fab2s/OpinHelpers) which packages several bellow "Swiss Army Knife" level Helpers covering some of the most annoying aspects of php programing, such as UTF8 string manipulation, high precision Mathematics or properly locking a file

Should you need to work with php bellow 7.1, you can still use [OpinHelper](https://github.com/fab2s/OpinHelpers) `0.x`

## Prerequisites

`Utf8` requires [mb_string](https://php.net/mb_string), [ext-intl](https://php.net/intl) is auto detected and used when available for UTF-8 Normalization

## In practice

`Utf8` offers replacement for most native string functions with support for UTF-8:

- `Utf8::strrpos(string string $str, string $needle, int $offset = null):int|false`
    
    UTF-8 aware [strrpos()](https://php.net/strrpos) replacement

- `Utf8::strpos(string $str, string $needle, int $offset = 0):int|false` 
    
    UTF-8 aware [strpos()](https://php.net/strpos) replacement

- `Utf8::strtolower(string $str):string`
    
    UTF-8 aware [strtolower()](https://php.net/strtolower) replacement

- `Utf8::strtoupper(string $str):string`
    
    UTF-8 aware [strtoupper()](https://php.net/strtoupper) replacement

- `Utf8::substr(string $str, int $offset, int $length = null):string`
    
    UTF-8 aware [substr()](https://php.net/substr) replacement

- `Utf8::strlen(string $str):int`
    
    UTF-8 aware [strlen()](https://php.net/strlen) replacement

- `Utf8::ucfirst(string $str):string`
    
    UTF-8 aware [ucfirst()](https://php.net/ucfirst) replacement

- `Utf8::ucwords(string $str):string`
    
    UTF-8 aware [ucwords()](https://php.net/ucwords) replacement

- `Utf8::ord(string $chr):int|false`
    
    UTF-8 aware [ord()](https://php.net/ord) replacement

- `Utf8::chr(int $num):string|false`
    
    UTF-8 aware [chr()](https://php.net/chr) replacement

And some simple utility methods:

- `Utf8::normalize(string $string, int $canonicalForm = self::NORMALIZE_NFC):string`
    
    UTF-8 [ext-intl](https://php.net/intl) [Normalizer](https://php.net/normalizer.normalize)
    > **WARNING**: This method will do nothing in case `ext-intl` is not installed on the host
    > This means it is up to you to make sure about it using `Utf8::normalizerSupport` 
    > or by adding `ext-intl` as a requirement to your project's `composer.json` file

- `Utf8::hasUtf8(string $string):bool`
    
    Tells if the input string contains some UTF-8

- `Utf8::isUtf8(string $string):bool`
    
    Tells if the input string is valid UTF-8

- `Utf8::replaceMb4(string $string, string $replace = ''):string`
    
    Replaces all [Utf8Mb4](https://stackoverflow.com/a/30074553/7630496) characters (aka mostly [emoji](https://en.wikipedia.org/wiki/Emoji))

- `Utf8::normalizerSupport(bool $disable = false):bool`
    
    Tells if [Normalizer](https://php.net/normalizer.normalize) is available or disable Normalizer support

## Requirements

`Utf8` is tested against php 7.2, 7.3, 7.4 and 8.0

## Contributing

Contributions are welcome, do not hesitate to open issues and submit pull requests.

## License

`Utf8` is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT)