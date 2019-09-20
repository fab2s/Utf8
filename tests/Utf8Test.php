<?php

/*
 * This file is part of Utf8.
 *     (c) Fabrice de Stefanis / https://github.com/fab2s/Utf8
 * This source file is licensed under the MIT license which you will
 * find in the LICENSE file or at https://opensource.org/licenses/MIT
 */

namespace fab2s\Utf8\Tests;

use fab2s\Utf8\Utf8;

/**
 * Class Utf8Test
 */
class Utf8Test extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider strrposData
     *
     * @param string    $haystack
     * @param string    $needle
     * @param int|null  $offset
     * @param int|false $expected
     */
    public function testStrrpos(string $haystack, string $needle, ?int $offset, $expected)
    {
        $this->assertSame($expected, Utf8::strrpos($haystack, $needle, $offset));
    }

    /**
     * @return array
     */
    public function strrposData()
    {
        return [
            [
                'haystack' => 'this 😘 is a € test worth much €!! 😘 ohoh',
                'needle'   => 'µ',
                'offset'   => null,
                'expected' => false,
            ],
            [
                'haystack' => 'this 😘 is a € test worth much €!! 😘 ohoh',
                'needle'   => '€',
                'offset'   => null,
                'expected' => 30,
            ],
            [
                'haystack' => 'this 😘 is a € test worth much €!! 😘 ohoh',
                'needle'   => '😘',
                'offset'   => 10,
                'expected' => 34,
            ],
            [
                'haystack' => 'this 😘 is a € test worth much €!! 😘 ohoh',
                'needle'   => '😘',
                'offset'   => -4,
                'expected' => 34,
            ],
            [
                'haystack' => '',
                'needle'   => 'µ',
                'offset'   => null,
                'expected' => false,
            ],
            [
                'haystack' => 'iñtërnâtiônàlizætiøn',
                'needle'   => 'æ',
                'offset'   => null,
                'expected' => 15,
            ],
        ];
    }

    /**
     * @dataProvider strposData
     *
     * @param string    $haystack
     * @param string    $needle
     * @param int|null  $offset
     * @param int|false $expected
     */
    public function testStrpos(string $haystack, string $needle, ?int $offset, $expected)
    {
        $this->assertSame($expected, Utf8::strpos($haystack, $needle, $offset));
    }

    /**
     * @return array
     */
    public function strposData()
    {
        return [
            [
                'haystack' => 'this 😘 is a € test worth much €!! 😘 ohoh',
                'needle'   => 'µ',
                'offset'   => null,
                'expected' => false,
            ],
            [
                'haystack' => 'this 😘 is a € test worth much €!! 😘 ohoh',
                'needle'   => '€',
                'offset'   => null,
                'expected' => 12,
            ],
            [
                'haystack' => 'this 😘 is a € test worth much €!! 😘 ohoh',
                'needle'   => '😘',
                'offset'   => 10,
                'expected' => 34,
            ],
            [
                'haystack' => 'this 😘 is a € test worth much €!! 😘 ohoh',
                'needle'   => '😘',
                'offset'   => -4,
                'expected' => false,
            ],
            [
                'haystack' => 'this 😘 is a € test worth much €!! 😘 ohoh',
                'needle'   => '😘',
                'offset'   => -10,
                'expected' => 34,
            ],
            [
                'haystack' => '',
                'needle'   => 'µ',
                'offset'   => null,
                'expected' => false,
            ],
            [
                'haystack' => 'iñtërnâtiônàlizætiøn',
                'needle'   => 'æ',
                'offset'   => null,
                'expected' => 15,
            ],
        ];
    }

    public function testStrtoupper()
    {
        $string   = 'iñtërnâtiônàlizætiøn';
        $expected = 'IÑTËRNÂTIÔNÀLIZÆTIØN';
        $this->assertSame($expected, Utf8::strtoupper($string));
    }

    /**
     * @dataProvider ucfirstData
     *
     * @param string $string
     * @param string $expected
     */
    public function testUcfirst(string $string, string $expected)
    {
        $this->assertSame($expected, Utf8::ucfirst($string));
    }

    /**
     * @return array
     */
    public function ucfirstData()
    {
        return [
            [
                'string'   => 'ñtërnâtiônàlizætiøn',
                'expected' => 'Ñtërnâtiônàlizætiøn',
            ],
            [
                'string'   => ' ñtërnâtiônàlizætiøn',
                'expected' => ' ñtërnâtiônàlizætiøn',
            ],
            [
                'string'   => 'ñtërnâtiônàlizætiøn ñtërnâtiônàlizætiøn',
                'expected' => 'Ñtërnâtiônàlizætiøn ñtërnâtiônàlizætiøn',
            ],
            [
                'string'   => '',
                'expected' => '',
            ],
            [
                'string'   => 'ñ',
                'expected' => 'Ñ',
            ],
        ];
    }

    /**
     * @dataProvider ucwordsData
     *
     * @param string $string
     * @param string $expected
     */
    public function testUcwords(string $string, string $expected)
    {
        $this->assertSame($expected, Utf8::ucwords($string));
    }

    /**
     * @return array
     */
    public function ucwordsData()
    {
        return [
            [
                'string'   => 'iñt ërn âti ônà liz æti øn',
                'expected' => 'Iñt Ërn Âti Ônà Liz Æti Øn',
            ],
            [
                'string'   => ' ñtërnâtiônàlizætiøn',
                'expected' => ' Ñtërnâtiônàlizætiøn',
            ],
            [
                'string'   => 'ñtërnâtiônàlizætiøn ñtërnâtiônàlizætiøn',
                'expected' => 'Ñtërnâtiônàlizætiøn Ñtërnâtiônàlizætiøn',
            ],
            [
                'string'   => '',
                'expected' => '',
            ],
            [
                'string'   => 'ñ',
                'expected' => 'Ñ',
            ],
        ];
    }

    /**
     * @dataProvider hasUtf8Data
     *
     * @param string $string
     * @param bool   $expected
     */
    public function testHasUtf8(string $string, bool $expected)
    {
        $this->assertSame($expected, Utf8::hasUtf8($string));
        $this->assertTrue(Utf8::isUtf8($string));
    }

    /**
     * @return array
     */
    public function hasUtf8Data()
    {
        return [
            [
                'string'   => 'ñtërnâtiônàlizætiøn',
                'expected' => true,
            ],
            [
                'string'   => 'abc',
                'expected' => false,
            ],
            [
                'string'   => "a\nb\tc",
                'expected' => false,
            ],
            [
                'string'   => "a\nb\tc 😘",
                'expected' => true,
            ],
        ];
    }

    /**
     * @dataProvider ordData
     *
     * @param string    $char
     * @param int|false $expected
     */
    public function testOrd(string $char, $expected)
    {
        $num = Utf8::ord($char);
        $this->assertSame($expected, $num);

        if ($expected !== false) {
            $this->assertSame($char, Utf8::chr($num));
        }
    }

    /**
     * @return array
     */
    public function ordData(): array
    {
        return [
            [
                'char'     => '',
                'expected' => false,
            ],
            [
                'char'     => ' ',
                'expected' => 32,
            ],
            [
                'char'     => "\0",
                'expected' => 0,
            ],
            [
                'char'     => 'a',
                'expected' => 97,
            ],
            [
                'char'     => 'ñ',
                'expected' => 241,
            ],
            [
                'char'     => '₧',
                'expected' => 8359,
            ],
            [
                'char'     => '🍵',
                'expected' => 127861,
            ],
        ];
    }

    /**
     * @dataProvider chrData
     *
     * @param int       $num
     * @param int|false $expected
     */
    public function testChr(int $num, $expected)
    {
        $char = Utf8::chr($num);
        $this->assertSame($expected, $char);

        if ($expected !== false) {
            $this->assertSame($num, Utf8::ord($char));
        }
    }

    /**
     * @return array
     */
    public function chrData(): array
    {
        return [
            [
                'num'      => 32,
                'expected' => ' ',
            ],
            [
                'num'      => 0,
                'expected' => "\0",
            ],
            [
                'num'      => 97,
                'expected' => 'a',
            ],
            [
                'num'      => 241,
                'expected' => 'ñ',
            ],
            [
                'num'      => 8359,
                'expected' => '₧',
            ],
            [
                'num'      => 127861,
                'expected' => '🍵',
            ],
            [
                'num'      => 123456789123456789,
                'expected' => false,
            ],
        ];
    }

    public function testStrlen()
    {
        $string   = 'Iñtërnâtiônàlizætiøn';
        $expected = 20;
        $this->assertSame($expected, Utf8::strlen($string));
    }

    /**
     * @dataProvider replaceMb4Data
     *
     * @param string $string
     * @param string $expected
     */
    public function testReplaceMb4(string $string, string $expected)
    {
        $this->assertSame($expected, Utf8::replaceMb4($string));
    }

    /**
     * @return array
     */
    public function replaceMb4Data(): array
    {
        return [
            // string, expected
            ['this is a test with an emoji!! 😘 ohoh', 'this is a test with an emoji!!  ohoh'],
            ['this is a test with many 🍵🍶 emoji!! 🍷🍸 ahah', 'this is a test with many  emoji!!  ahah'],
        ];
    }
}
