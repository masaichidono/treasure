<?php


namespace Masaichi\Treasure\cache;

//此类是缓存的service，提供统一的操作方法
use Masaichi\Treasure\cache\src\MRedis;
use Masaichi\Treasure\common\traits\Single;
use Masaichi\Treasure\exceptions\InvalidArgumentException;

class MCache
{
    use Single;

    protected $type        = 'redis'; //类型 redis  memcache
    protected $cacheClient = null; //缓存操作类

    public function __construct(string $type = 'redis')
    {
        //实例化
        if ($type == 'redis') {
            $this->cacheClient = new MRedis();
        } else {
            throw new InvalidArgumentException($type . ' 暂不支持');
        }
    }

    /**
     * 设置缓存
     * @param $key
     * @param $value
     * @param int $expireTime
     * @return bool
     */
    public function set($key, $value, $expireTime = 180)
    {
        return $this->cacheClient->set($key, $value, $expireTime);
    }

    /**
     * 获取缓存
     * @param $key
     * @return bool
     */
    public function get($key)
    {
        return $this->cacheClient->get($key);
    }

    /**
     * 加锁
     * @param $key
     * @param int $expireTime
     * @return bool
     */
    public function lock($key, $expireTime = 180)
    {
        return $this->cacheClient->lock($key, $expireTime);
    }

    /**
     * 解锁
     * @param $key
     */
    public function unlock($key)
    {
        return $this->cacheClient->unlock($key);
    }

    /**
     * 删除缓存
     * @param $key
     * @return bool
     */
    public function delete($key)
    {
        return $this->cacheClient->delete($key);
    }

    /**
     * 缓存值自增
     * @param $key
     * @param $step
     * @param int $expireTime
     * @return bool
     */
    public function inc($key, $step = 1, $expireTime = 180)
    {
        return $this->cacheClient->inc($key, $step, $expireTime);
    }

    /**
     * 缓存值自减
     * @param $key
     * @param $step
     * @param int $expireTime
     * @return bool
     */
    public function dec($key, $step, $expireTime = 180)
    {
        return $this->cacheClient->dec($key, $step, $expireTime);
    }
}