<?php
//导出
require_once "./../MExcel.php";
require_once "./../../../vendor/autoload.php";
$fileName = './test.xlsx';
$fieldName = ['id' => '编号', 'number' => '学号'];
$data = [
    ['id' => 1, 'number' => '123'],
    ['id' => 2, 'number' => '456'],
];
\Masaichi\excel\PHPExcel::exportData($data, $fieldName, $fileName);

//获取excel内容，默认从第二行开始获取
$fileName = './test.xlsx';
$fieldName = [
    '编号' => 'id',
    '学号' => 'num',
];
\Masaichi\Treasure\excel\MExcel::getExcelData($fileName, $fieldName);