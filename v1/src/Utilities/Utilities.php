<?php
/**
 * Created by PhpStorm.
 * User: lilipeng
 * Date: 12/9/17
 * Time: 11:59
 */

namespace Restaurant\Utilities;

class Utilities
{
    public static function unique_id(): int
    {
        return mt_rand(100000000, 999999999);
    }
}