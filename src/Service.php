<?php

namespace Src;

class Service
{
    private $conn;
    private $csvGenerator;


    public function __construct()
    {
        $this->conn = Database::getInstance();
        $this->csvGenerator = new CsvGenerator();
    }


    /**
     * Обрабатываем входящиие данные POST запроса
     * @param array $data
     * @return void
     */
    public function handleRequest(array $data): void
    {
        $key = $data['key'];

        if (!$this->validateKey($key)) {
            http_response_code(400);
            echo "Invalid key provided";
            return;
        }

        $records = $this->conn->getRecordsByKey($key);


        if (empty($records)) {
            http_response_code(404);
            echo "No records found";
            return;
        }

        $csvData = $this->csvGenerator->generateCsvFile($records);

        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=records.csv");

        echo $csvData;
    }


    /**
     * Валидация данных
     * @param string $key
     * @return bool
     */
    private function validateKey(string $key): bool
    {
        if (gettype($key) === 'string') {
            return true;
        }
        return false;
    }
}