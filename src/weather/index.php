<?php


require __DIR__ . '/../../vendor/autoload.php';

use Masaichi\Treasure\weather\Weather;

// 高德开放平台应用 API Key
$key = 'a25e9710f44e8bb11edb47ea9617fbd3';
$w   = new Weather($key);

echo "获取实时天气：\n";

$response = $w->getWeather('深圳');
echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

echo "\n\n获取天气预报：\n";

$response = $w->getWeather('深圳', 'all');
echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);


echo "\n\n获取实时天气(XML)：\n";

echo $w->getWeather('深圳', 'base', 'xml');