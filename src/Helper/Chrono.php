<?php

namespace App\Helper;

class Chrono
{
    public static function extractChrono(string $chrono): int
    {
        return (int) substr($chrono, 0, 2);
    }
}
