<?php

namespace App\Helpers;

class FormatPhoneNumber
{
    /**
     * Convert an Arabic numeral to Khmer numerals.
     *
     * @param int|string $number
     * @return string
     */
    public static function format($phone)
    {
        $cleanedPhone = preg_replace('/\s+/', '', $phone);
        if (preg_match('/^\d{9,}$/', $cleanedPhone)) {
            return preg_replace('/^(\d{3})(\d{3})(\d+)$/', '$1-$2-$3', $cleanedPhone);
        }
        return $phone;
    }
    public static function formatView($phone)
    {
        $cleanedPhone = preg_replace('/\s+/', '', $phone);
        if (preg_match('/^\d{9,}$/', $cleanedPhone)) {
            return preg_replace('/^(\d{3})(\d{3})(\d+)$/', '$1 $2 $3', $cleanedPhone);
        }
        return $phone;
    }
}
