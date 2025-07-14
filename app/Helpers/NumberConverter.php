<?php

namespace App\Helpers;

class NumberConverter
{
    /**
     * Convert an Arabic numeral to Khmer numerals.
     *
     * @param int|string $number
     * @return string
     */
    public static function toKhmer($number)
    {
        $khmerNumerals = [
            '0' => '០',
            '1' => '១',
            '2' => '២',
            '3' => '៣',
            '4' => '៤',
            '5' => '៥',
            '6' => '៦',
            '7' => '៧',
            '8' => '៨',
            '9' => '៩',
        ];

        return strtr((string) $number, $khmerNumerals);
    }

    public static function toEnglish($number)
    {
        // Khmer to English numerals mapping
        $khmerToEnglishNumerals = [
            '០' => '0',
            '១' => '1',
            '២' => '2',
            '៣' => '3',
            '៤' => '4',
            '៥' => '5',
            '៦' => '6',
            '៧' => '7',
            '៨' => '8',
            '៩' => '9',
        ];

        // Convert Khmer numerals to English numerals
        return strtr((string) $number, $khmerToEnglishNumerals);
    }

    public static function convertToEnglishNumerals($numberString)
    {
        $khmerNumerals = [
            '០' => '0',
            '១' => '1',
            '២' => '2',
            '៣' => '3',
            '៤' => '4',
            '៥' => '5',
            '៦' => '6',
            '៧' => '7',
            '៨' => '8',
            '៩' => '9',
        ];


        // Convert each Khmer numeral to its English equivalent
        return strtr($numberString, $khmerNumerals);
    }

    public static function formatStudentCode($number, $length = 5, $prefix = 'STU')
    {
        // Pad number with leading zeros
        $paddedNumber = str_pad($number, $length, '0', STR_PAD_LEFT);

        // Combine with prefix
        return $prefix . $paddedNumber;
    }

    function getColumnLetter($index) {
        $letters = '';
        while ($index >= 0) {
            $letters = chr(65 + ($index % 26)) . $letters;
            $index = floor($index / 26) - 1;
        }
        return $letters;
    }
}
