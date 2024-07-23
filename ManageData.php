<?php

class ManageData
{
    const HOST = 'localhost';
    const USER = 'root';
    const DATA_BASE = 's2';
    const PASSWORD = '';
    private PDO $con;

    public function __construct()
    {
        $dsn = 'mysql:dbname='.self::DATA_BASE.";host=".self::HOST;
        $this->con = new PDO($dsn, self::USER, self::PASSWORD);
    }

    public function executeQuery(string $query, array $params = []){
        $stmt = $this->con->prepare($query);
        $stmt->execute($params);
    }

    public function getData(string $query, bool $singleData=false, array $params = []): array|bool {
        $stmt = $this->con->prepare($query);
        $stmt->execute($params);
        if ($singleData) {
            return $stmt->fetch();
        } else {
            return $stmt->fetchAll();
        }
    }

    public function getLastInsertId() {
        return $this->con->lastInsertId();
    }
}