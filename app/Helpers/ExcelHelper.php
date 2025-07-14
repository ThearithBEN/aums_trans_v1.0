<?php

namespace App\Helpers;

namespace App\Helpers;

class ExcelHelper {
    public static function getColumnLetter($index) {
        $letter = '';
        while ($index >= 0) {
            $letter = chr($index % 26 + 65) . $letter;
            $index = floor($index / 26) - 1;
        }
        return $letter;
    }
}
