<?php


namespace Masaichi\Treasure\cache\src;


class BaseCache
{
    protected $expireTime = 120;

    /**
     * 缓存控制，如果是测试环境或者携带指定参数可以不走缓存
     *
     * @return bool
     */
    protected function controlCache()
    {
        //获取get或者post参数
        $cache = isset($_REQUEST['__cache']) ? $_REQUEST['__cache'] : '';
        if ($cache == 'delete') {
            return false;
        }
        return true;
    }
}