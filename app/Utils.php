<?php


namespace App;


/**
 * Class Utils
 * @package App
 */
class Utils
{
    /**
     * @param int $dayNumber
     * @return string
     */
    public static function getDayNameByNumber(int $dayNumber): string
    {
        return date('l', strtotime("Sunday +{$dayNumber} days"));
    }
}
