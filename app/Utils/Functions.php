<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: SillyCat
 * Date: 2025-06-18
 * Time: 17:18
 */

if (! function_exists('convert_size')) {
    /**
     * 将字节转化为 kb mb 等单位
     * @param $size
     * @return string
     */
    function convert_size($size)
    {
        $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];
        return @round($size / pow(1024, $i = floor(log($size, 1024))), 2) . ' ' . $unit[$i];
    }
}