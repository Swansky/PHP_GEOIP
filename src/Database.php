<?php

class Database
{
    private const CHARSET = "utf8";
    private PDO $pdo;

    public function connect(Parameter $parameter): void
    {
        try {
            $this->pdo = new PDO('mysql:host=' . $parameter->getBddHost() .
                ';dbname=' . $parameter->getBddName() .
                ';charset=' . self::CHARSET,
                $parameter->getBddUsername(),
                $parameter->getBddPassword(), array(
                    PDO::MYSQL_ATTR_LOCAL_INFILE => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL
                ));
        } catch (PDOException $ex) {
            ErrorUtils::SendCriticalError("Unable to connect to the database: " . $ex->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

}