<?php

namespace App\Helpers;

class Helper
{
    public static function getRupiah($value)
    {
        $res = "IDR " . number_format($value, 0, ',', '.');
        return $res;
    }

    public static function getFormatWib($tanggal)
    {
        return date('d-m-Y H:i', strtotime($tanggal)) . ' Wib';
    }
}
