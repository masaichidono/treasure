<?php


namespace Masaichi\Treasure\common\traits;


trait Single
{
    private static $instance = null;

    /**
     * @param mixed ...$args
     * @return static
     */
    public static function getInstance(...$args)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static(...$args);
        }
        return static::$instance;
    }
}