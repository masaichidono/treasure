<?php


namespace Masaichi\Treasure\cache\src;


interface BaseCacheInterface
{
    //获取缓存
    public function get(string $key);
    //设置缓存
    public function set(string $key, $value, $expireTime = 120);
    //删除缓存
    public function delete(string $key);
    //缓存值自增
    public function inc(string $key, int $step = 1, $expireTime = 180);
    //缓存值自减
    public function dec(string $key, int $step = 1, $expireTime = 180);
    //加锁
    public function lock(string $key, $expireTime = 180);
    //解锁
    public function unlock(string $key);
}