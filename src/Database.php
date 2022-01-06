<?php

class Database
{
    private const HOST = "127.0.0.1";
    private const DB_NAME = "tp-geoip";
    private const CHARSET = "utf8";
    private const USERNAME = "root";
    private const PASSWORD = "example";
    private PDO $pdo;

    public function connect(): void
    {
        try {
            $this->pdo = new PDO('mysql:host=' . self::HOST .
                ';dbname=' . self::DB_NAME .
                ';charset=' . self::CHARSET,
                self::USERNAME,
                self::PASSWORD);
        } catch (PDOException $ex) {

            ErrorUtils::SendCriticalError("Unable to connect to the database: " . $ex->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

}