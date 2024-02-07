<?php

namespace Src;

class CsvGenerator
{
    /**
     * Генерируем csv файл с разделителем в виде запятой
     * @param array $data
     * @return string
     */
    public function generateCsvFile(array $data): string
    {
        $csvData = implode(',', array_keys($data[0])) . PHP_EOL;
        foreach ($data as $record) {
            $csvData .= $record['id'] . "," . $record['title'] . "," . $record['score'] . "," . $record['key'] . PHP_EOL;
        }
        return $csvData;
    }
}