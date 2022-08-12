#### Excel

---
## 使用
### 一 导出excel
```php
$fileName = './test.xlsx';
$fieldName = ['id' => '编号', 'number' => '学号'];
$data = [
    ['id' => 1, 'number' => '123'],
    ['id' => 2, 'number' => '456'],
];
\Masaichi\excel\PHPExcel::exportData($data, $fieldName, $fileName);
```
结果图：  
![avatar](http://cdn.masaichi.top/%E5%BE%AE%E4%BF%A1%E6%88%AA%E5%9B%BE_20220812175709.png)

### 二 获取excel数据
```php
//获取excel内容，默认从第二行开始获取
$fileName = './test.xlsx';
$fieldName = [
    '编号' => 'id',
    '学号' => 'num',
];
\Masaichi\Treasure\excel\MExcel::getExcelData($fileName, $fieldName);
```
结果：
```json
[{"id":"1","num":"123"},{"id":"2","num":"456"}]
```