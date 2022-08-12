<?php
//导出
require_once "./../PHPExcel.php";
require_once "./../../../vendor/autoload.php";
$fileName = './test.xlsx';
$fieldName = ['id' => '编号', 'number' => '学号'];
$data = [
    ['id' => 1, 'number' => '123'],
    ['id' => 2, 'number' => '456'],
];
\Masaichi\excel\PHPExcel::exportData($data, $fieldName, $fileName);
