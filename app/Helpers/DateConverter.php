<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Helpers\NumberConverter;

class DateConverter
{
    /**
     * Convert a Gregorian date to Khmer date format.
     *
     * @param string $date
     * @return string
     */
    public static function toKhmerDate($date)
    {
        $carbonDate = Carbon::parse($date);

        // Khmer year calculation
        // $khmerYear = $carbonDate->year + 543;
        $khmerYear = NumberConverter::toKhmer($carbonDate->year);

        // Khmer month names
        $khmerMonths = [
            1 => 'មករា',
            2 => 'កុម្ភៈ',
            3 => 'មិនា',
            4 => 'មេសា',
            5 => 'ឧសភា',
            6 => 'មិថុនា',
            7 => 'កក្កដា',
            8 => 'សីហា',
            9 => 'កញ្ញា',
            10 => 'តុលា',
            11 => 'វិច្ឆិកា',
            12 => 'ធ្នូ'
        ];

        $khmerMonth = $khmerMonths[$carbonDate->month];
        $khmerDay = NumberConverter::toKhmer($carbonDate->day);

        return "{$khmerDay} {$khmerMonth} {$khmerYear}";
    }

    public static function toEnglishDate($date)
    {
        // Convert Khmer numerals to English numerals
        $date = NumberConverter::toEnglish($date);

        // Map Khmer month names to their corresponding numeric values
        $khmerMonthsToEnglish = [
            'មករា' => '01',
            'កុម្ភៈ' => '02',
            'មិនា' => '03',
            'មេសា' => '04',
            'ឧសភា' => '05',
            'មិថុនា' => '06',
            'កក្កដា' => '07',
            'សីហា' => '08',
            'កញ្ញា' => '09',
            'តុលា' => '10',
            'វិច្ឆិកា' => '11',
            'ធ្នូ' => '12'
        ];

        // Split the date string into components
        preg_match('/(\d+)\s+([^\d]+)/', $date, $matches);

        if (count($matches) < 3) {
            throw new \Exception("Date format is incorrect: $date");
        }

        $day = NumberConverter::convertToEnglishNumerals(trim($matches[1])); // Get day
        $monthKhmer = trim($matches[2]); // Get month in Khmer

        // Convert Khmer month to numeric month
        if (isset($khmerMonthsToEnglish[$monthKhmer])) {
            $month = $khmerMonthsToEnglish[$monthKhmer];
        } else {
            throw new \Exception("Invalid month name: $monthKhmer");
        }

        // Extract year from the date
        $year = explode(' ', $date)[2]; // Assuming the year is the last part

        // Format the date as YYYY-MM-DD
        return "{$year}-{$month}-" . str_pad($day, 2, '0', STR_PAD_LEFT);
    }

}
