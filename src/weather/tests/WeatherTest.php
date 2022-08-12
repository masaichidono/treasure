<?php


namespace Masaichi\Treasure\weather\tests;


use http\Exception\InvalidArgumentException;
use Masaichi\Treasure\weather\Weather;
use PHPUnit\Framework\TestCase;

class WeatherTest extends TestCase
{
    public function testGetWeatherWithInvalidType()
    {
        $w = new Weather('mock-key');
        //断言会抛出此异常类
        $this->expectException(InvalidArgumentException::class);
        //断言异常消息为
        $this->expectExceptionMessage("Invalid type value(base/all): foo");
        $w->getWeather("深圳", "foo");
        $this->fail("Failed to assert getWeather throw exception with invalid argument.");
    }

    public function testGetWeatherWithInvalidFormat()
    {
        $w = new Weather('mock-key');
        //断言会抛出此异常类
        $this->expectException(InvalidArgumentException::class);
        //断言异常消息为
        $this->expectExceptionMessage("Invalid response format: array");
        //因为支持的格式为 xml/json,所以传入array会抛出异常
        $w->getWeather("深圳", "base", "array");
        // 如果没有抛出异常，就会运行到这行，标记当前测试没成功
        $this->fail('Failed to assert getWeather throw exception with invalid argument.');
    }

    public function testSetGuzzleOptions()
    {

    }
}