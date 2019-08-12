<?php

/*
 * This file is part of Utf8.
 *     (c) Fabrice de Stefanis / https://github.com/fab2s/Utf8
 * This source file is licensed under the MIT license which you will
 * find in the LICENSE file or at https://opensource.org/licenses/MIT
 */

namespace fab2s\Utf8;

/**
 * UTF8 string manipulations
 */
class Utf8
{
    /**
     * utf8 charset name in mb dialect
     */
    const ENC_UTF8 = 'UTF-8';

    /**
     * \Normalizer::NFC
     */
    const NORMALIZE_NFC = 4;

    /**
     * \Normalizer::NFD
     */
    const NORMALIZE_NFD = 2;

    /**
     * @var bool
     */
    protected static $normalizerSupport = false;

    /**
     * @var bool
     */
    protected static $ordSupport = false;

    /**
     * strrpos
     *
     * @param string $haystack
     * @param string $needle
     * @param int    $offset
     *
     * @return int|false
     */
    public static function strrpos(string $haystack, string $needle, ?int $offset = 0)
    {
        // Emulate strrpos behaviour (no warning)
        if (empty($haystack)) {
            return false;
        }

        return mb_strrpos($haystack, $needle, $offset, static::ENC_UTF8);
    }

    /**
     * strpos
     *
     * @param string $haystack
     * @param string $needle
     * @param int    $offset
     *
     * @return int|false
     */
    public static function strpos(string $haystack, string $needle, $offset = 0)
    {
        return mb_strpos($haystack, $needle, $offset, static::ENC_UTF8);
    }

    /**
     * strtolower
     *
     * @param string $string
     *
     * @return string
     */
    public static function strtolower(string $string): string
    {
        return mb_strtolower($string, static::ENC_UTF8);
    }

    /**
     * strtoupper
     *
     * @param string $string
     *
     * @return string
     */
    public static function strtoupper(string $string): string
    {
        return mb_strtoupper($string, static::ENC_UTF8);
    }

    /**
     * @param string   $string
     * @param int      $offset
     * @param int|null $length
     *
     * @return string
     */
    public static function substr(string $string, int $offset, ?int $length = null): string
    {
        return mb_substr($string, $offset, $length === null ? mb_strlen($string, static::ENC_UTF8) : $length, static::ENC_UTF8);
    }

    /**
     * strlen
     *
     * @param string $string
     *
     * @return int
     */
    public static function strlen(string $string): int
    {
        return mb_strlen($string, static::ENC_UTF8);
    }

    /**
     * ucfirst
     *
     * @param string $string
     *
     * @return string
     */
    public static function ucfirst(string $string): string
    {
        switch (static::strlen($string)) {
            case 0:
                return '';
            case 1:
                return static::strtoupper($string);
            default:
                return static::strtoupper(static::substr($string, 0, 1)) . static::substr($string, 1);
        }
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function ucwords(string $string): string
    {
        return mb_convert_case($string, MB_CASE_TITLE, static::ENC_UTF8);
    }

    /**
     * ord
     *
     * @param string $chr
     *
     * @return int|false
     */
    public static function ord(string $chr)
    {
        if (($strLen = strlen($chr)) === 0) {
            return false;
        }

        if (static::$ordSupport) {
            return mb_ord($chr, static::ENC_UTF8);
        }

        return static::ordCompat($chr, $strLen);
    }

    /**
     * chr
     *
     * @param int $num
     *
     * @return string|false
     */
    public static function chr(int $num)
    {
        if ($num === 0) {
            return "\0";
        }

        if (static::$ordSupport) {
            return mb_chr($num, static::ENC_UTF8);
        }

        // prolly the fastest
        $result = mb_convert_encoding($input = '&#' . $num . ';', static::ENC_UTF8, 'HTML-ENTITIES');

        return $result !== $input ? $result : false;
    }

    /**
     * normalize an utf8 string to canonical form
     * Default to NFC
     *
     * @see https://stackoverflow.com/a/7934397/7630496
     *
     * @param string $string
     * @param int    $canonicalForm
     *
     * @return string
     */
    public static function normalize(string $string, int $canonicalForm = self::NORMALIZE_NFC): string
    {
        if (static::$normalizerSupport) {
            return \Normalizer::normalize($string, $canonicalForm);
        }

        return $string;
    }

    /**
     * tels if a string contains utf8 chars (which may not be valid)
     *
     * @param string $string
     *
     * @return bool
     */
    public static function hasUtf8(string $string): bool
    {
        // From http://w3.org/International/questions/qa-forms-utf-8.html
        // non-overlong 2-byte|excluding overlong|straight 3-byte|excluding surrogates|planes 1-3|planes 4-15|plane 16
        return (bool) preg_match('%(?:[\xC2-\xDF][\x80-\xBF]|\xE0[\xA0-\xBF][\x80-\xBF]|[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}|\xED[\x80-\x9F][\x80-\xBF] |\xF0[\x90-\xBF][\x80-\xBF]{2}|[\xF1-\xF3][\x80-\xBF]{3}|\xF4[\x80-\x8F][\x80-\xBF]{2})+%xs', $string);
    }

    /**
     * @param string $string
     *
     * @return bool
     */
    public static function isUtf8(string $string): bool
    {
        return (bool) preg_match('//u', $string);
    }

    /**
     * Remove any 4byte multi bit chars, useful to make sure we can insert in utf8-nonMb4 db tables
     *
     * @param string $string
     * @param string $replace
     *
     * @return string
     */
    public static function replaceMb4(string $string, string $replace = ''): string
    {
        return preg_replace('%(?:
            \xF0[\x90-\xBF][\x80-\xBF]{2}      # planes 1-3
            | [\xF1-\xF3][\x80-\xBF]{3}        # planes 4-15
            | \xF4[\x80-\x8F][\x80-\xBF]{2}    # plane 16
        )%xs', $replace, $string);
    }

    /**
     * @param bool $disable
     *
     * @return bool
     */
    public static function normalizerSupport(bool $disable = false): bool
    {
        if ($disable) {
            return static::$normalizerSupport = false;
        }

        return static::$normalizerSupport = function_exists('normalizer_normalize');
    }

    /**
     * Performs the few compatibility operations
     */
    public static function support()
    {
        static::normalizerSupport();
        static::$ordSupport = function_exists('mb_ord');
    }

    /**
     * @param string $chr
     * @param int    $strLen
     *
     * @return int|false
     */
    protected static function ordCompat(string $chr, int $strLen)
    {
        switch ($strLen) {
            case 1:
                return ord($chr);
            case 2:
                return ((ord($chr[0]) & 0x1F) << 6) | (ord($chr[1]) & 0x3F);
            case 3:
                return ((ord($chr[0]) & 0x0F) << 12) | ((ord($chr[1]) & 0x3F) << 6) | (ord($chr[2]) & 0x3F);
            case 4:
                return ((ord($chr[0]) & 0x07) << 18) | ((ord($chr[1]) & 0x3F) << 12) | ((ord($chr[2]) & 0x3F) << 6) | (ord($chr[3]) & 0x3F);
            default:
                return false;
        }
    }
}

// OMG a dynamic static anti pattern ^^
Utf8::support();
