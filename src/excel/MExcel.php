<?php

namespace Masaichi\Treasure\excel;

use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Writer\WriterFactory;

/**
 * Excel工具类.
 */
class MExcel
{
    protected $type      = 'w';
    protected $fieldname = [];
    /** @var \Box\Spout\Writer\XLSX\Writer */
    protected $writer;
    /** @var object */
    protected $reader;

    /**
     * 初始化.
     *
     * @param string $filename   文件名
     * @param array  $fieldname  说明
     * @param string $type       读写类型
     * @param string $fileType   文件类型
     * @param bool   $isdownload 是否下载
     */
    public function __construct($filename, $fieldname, $type = 'w', $fileType = 'XLSX', $isdownload = true)
    {
        $this->type = $type;
        if ('w' == $type) {
            $this->writer($filename, $fieldname, $fileType, $isdownload);
        } elseif (('r' == $type)) {
            $this->reader($filename, $fileType);
        }
    }

    /**
     * 写入.
     *
     * @param string $filename
     * @param array  $fieldname
     * @param string $fileType
     * @param bool   $isdownload
     *
     * @return void
     */
    public function writer($filename = '', $fieldname = [], $fileType = 'XLSX', $isdownload = true)
    {
        if ('XLSX' == $fileType) {
            $this->writer = WriterFactory::create(Type::XLSX); // for XLSX files
        } elseif ('CSV' == $fileType) {
            $this->writer = WriterFactory::create(Type::CSV); // for CSV files
        } elseif ('ODS' == $fileType) {
            $this->writer = WriterFactory::create(Type::ODS); // for ODS files
        }
        if ($isdownload) {
            $this->writer->openToBrowser($filename); // stream data directly to the browser
        } else {
            $this->writer->openToFile($filename); // write data to a file or to a PHP stream
        }
        $this->fieldname = $fieldname;
        foreach ($this->fieldname as $key => $value) {
            $temp[$key] = $value;
        }
        $this->writer->addRows([$temp]); // add a row at a time
    }

    /**
     * 读取.
     *
     * @param string $filePath
     * @param string $fileType
     *
     * @return void
     */
    public function reader($filePath, $fileType = 'XLSX')
    {
        if ('XLSX' == $fileType) {
            $this->reader = ReaderFactory::create(Type::XLSX); // for XLSX files
        } elseif ('CSV' == $fileType) {
            $this->reader = ReaderFactory::create(Type::CSV); // for CSV files
        } elseif ('ODS' == $fileType) {
            $this->reader = ReaderFactory::create(Type::ODS); // for ODS files
        }
        $this->reader->open($filePath);
    }

    /**
     * 获取表格迭代器.
     *
     * @return object
     */
    public function getSheetIterator()
    {
        return $this->reader->getSheetIterator();
    }

    /**
     * 获取行数据迭代器.
     *
     * @return object
     */
    public function getRowIterator()
    {
        $sheetIterator = $this->getSheetIterator();
        $sheetIterator->rewind();
        $sheet1 = $sheetIterator->current();

        return $sheet1->getRowIterator();
    }

    /**
     * 写入数据.
     *
     * @param array $data
     */
    public function write($data)
    {
        if (!$data) {
            return;
        }
        $list = [];
        foreach ($data as $item) {
            foreach ($this->fieldname as $key => $value) {
                $temp[$key] = $item[$key] ?? '';
            }
            $list[] = $temp;
        }
        $this->writer->addRows($list); // add multiple rows at a time
    }

    /**
     * 关闭.
     *
     * @param bool $isExit
     */
    public function close($isExit = true)
    {
        if ('w' == $this->type) {
            $this->writer->close();
        } elseif ('r' == $this->type) {
            $this->reader->close();
        }
        if ($isExit) {
            exit();
        }
    }

    /**
     * 导出数据.
     *
     * @param array  $data       数据
     * @param array  $fieldName  导出的字段
     * @param string $fileName   文件名
     * @param string $type       导出类型
     * @param boolen $isDownLoad 是否直接下载
     */
    public static function exportData($data, $fieldName, $fileName, $type = 'XLSX', $isDownLoad = true)
    {
        foreach ($fieldName as $m => $n) {
            $temp[$m] = $n;
        }
        $exportData[] = $temp;
        if ($data) {
            foreach ($data as $k => $v) {
                foreach ($fieldName as $m => $n) {
                    $temp[$m] = $v[$m];
                }
                $exportData[] = $temp;
            }
        }

        if ('XLSX' == $type) {
            $writer = WriterFactory::create(Type::XLSX); // for XLSX files
        } elseif ('CSV' == $type) {
            $writer = WriterFactory::create(Type::CSV); // for CSV files
        } elseif ('ODS' == $type) {
            $writer = WriterFactory::create(Type::ODS); // for ODS files
        }

        if ($isDownLoad) {
            $writer->openToBrowser($fileName); // stream data directly to the browser
        } else {
            $writer->openToFile($fileName); // write data to a file or to a PHP stream
        }
        // $writer->addRow($singleRow); // add a row at a time
        $writer->addRows($exportData); // add multiple rows at a time

        $writer->close();
        exit();
    }

    //创建多一个sheet并设置名称
    public function createSheet($name)
    {
        $this->writer->addNewSheetAndMakeItCurrent();
        if (!empty($name)) {
            $sheet = $this->writer->getCurrentSheet();
            $sheet->setName($name);
        }
    }

    //设置行头
    public function setLineHeader($fieldName, $isReset = false)
    {
        if ($fieldName) {
            $temp = [];
            foreach ($fieldName as $m => $n) {
                $temp[$m] = $n;
            }
            $this->writer->addRows([$temp]);
            $isReset && $this->fieldname = $fieldName;
        }
    }

    //设置sheet名
    public function setSheetName($name)
    {
        if (!empty($name)) {
            $sheet = $this->writer->getCurrentSheet();
            $sheet->setName($name);
        }
    }

    private static function getReader($fileName, $fileType = 'XLSX')
    {
        if ('XLSX' == $fileType) {
            $reader = ReaderFactory::create(Type::XLSX); // for XLSX files
        } elseif ('CSV' == $fileType) {
            $reader = ReaderFactory::create(Type::CSV); // for CSV files
        } elseif ('ODS' == $fileType) {
            $reader = ReaderFactory::create(Type::ODS); // for ODS files
        }
        $reader->open($fileName);
        return $reader;
    }

    /**
     * @author zhengfeng
     *
     * @param $indexData  格式为： array('物流公司' => 'com');
     *
     * @return bool
     */
    public static function getExcelData($fileName, $indexData, $fileType = 'XLSX')
    {
        $reader        = self::getReader($fileName, $fileType);
        $sheetIterator = $reader->getSheetIterator();
        $sheetIterator->rewind();
        $sheet1  = $sheetIterator->current();
        $rowIter = $sheet1->getRowIterator();
        try {
            $keyData    = [];  //格式为  1 => com   1：excel列  com ： 字段名
            $returnData = [];
            foreach ($rowIter as $rk => $row) {
                $tmpData = [];
                // 过滤第一行
                if (!$row) {
                    continue;
                }
                if (1 == $rk) {
                    //第一行，获取到key
                    foreach ($row as $k => $v) {
                        $tmpIndex                 = $indexData[$v] ?? '';
                        $tmpIndex && $keyData[$k] = $tmpIndex;
                    }
                    continue;
                }
                foreach ($row as $k => $v) {
                    $keyName                       = $keyData[$k] ?? '';
                    $keyName && $tmpData[$keyName] = $v;
                }
                $tmpData && $returnData[] = $tmpData;
            }
        } catch (\Exception $e) {
            return false;
        }

        return $returnData;
    }
}
