<?php


namespace Masaichi\Treasure\common\traits;


trait Single
{
    private static $instance = null;

    public static function getInstance(...$args)
    {
        if (is_null(self::$instance)) {
            static::$instance = new static(...args);
        }
        return static::$instance;
    }
}