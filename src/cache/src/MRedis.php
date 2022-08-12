<?php


namespace Masaichi\Treasure\cache\src;

use think\facade\Cache;


class MRedis extends BaseCache implements BaseCacheInterface
{

    /**
     * 获取缓存
     * @param string $key
     * @return bool
     */
    public function get(string $key)
    {
        if (empty($key)) {
            return false;
        }
        if (!$this->controlCache()) {
            return false;
        }
        //获取
        $result = Cache::get($key);
        return $result;
    }

    /**
     * 设置缓存
     * @param string $key
     * @param $value
     * @param int $expireTime
     * @return bool
     */
    public function set(string $key, $value, $expireTime = 120)
    {
        if (empty($key) || empty($value)) {
            return false;
        }
        $result = Cache::set($key, $value, $expireTime);
        return $result;
    }

    public function lock(string $key, $expireTime = 180)
    {
        $lock = $this->get($key);
        if ($lock) {
            return true;
        }
        if (0 == $expireTime)  {
            $this->set($key, 1);
        } else {
            $this->set($key, 1, $expireTime);
        }
    }

    public function unlock(string $key)
    {
        $this->delete($key);
    }

    public function inc(string $key, int $step = 1, $expireTime = 180)
    {
        if (empty($key)) {
            return false;
        }
        $result = Cache::inc($key, $step);
        Cache::handler()->expire($key, $expireTime);
        return $result;
    }

    public function dec(string $key, int $step = 1, $expireTime = 180)
    {
        if (empty($key)) {
            return false;
        }
        $result = Cache::dec($key, $step);
        Cache::handler()->expire($key, $expireTime);
        return $result;
    }

    public function delete(string $key)
    {
        if (empty($key)) {
            return false;
        }
        $result = Cache::rm($key);
        return $result;
    }

}