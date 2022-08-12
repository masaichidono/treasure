<?php


namespace Masaichi\Treasure\weather;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\InvalidArgumentException;
use Masaichi\Treasure\weather\exceptions\Exception;
use Masaichi\Treasure\weather\exceptions\HttpException;

class Weather
{
    protected $key;
    protected $guzzleOptions = [];

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    //获取http客户端
    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    /**
     * 设置http客户端
     * @param array $options
     */
    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }

    /**
     * 获取天气
     * @param string $city
     * @param string $type
     * @param string $format
     * @return mixed|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getWeather(string $city, string $type = "base", string $format = "json")
    {
        //对format，和type进行参数检查
        if (!in_array($format, ['xml', 'json']))  {
            throw new InvalidArgumentException("Invalid response format: ". $format);
        }
        if (!in_array($type, ['base', 'all'])) {
            throw new InvalidArgumentException("Invalid type value(base/all): ". $type);
        }
        $url = 'https://restapi.amap.com/v3/weather/weatherInfo';
        //过滤掉空值
        $query = array_filter([
            'key'        => $this->key,
            'city'       => $city,
            'output'     => $format,
            'extensions' => $type,
        ]);
        try {
            $response = $this->getHttpClient()->get($url, [
                'query' => $query,
            ])->getBody()->getContents();

            return 'json' === $format ? json_decode($response, true) : $response;
        } catch (Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }


    }
}