<?php

namespace Database;

use PDO;
use PDOException;

class DatabaseConnection
{
    private $pdo;

    public function __construct(array $config)
    {
        #$dsn = "pgsql:host={$config['host']};dbname={$config['dbname']}";
        $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";

        $user = $config['user'];
        $password = $config['password'];

        // Mensajes de depuración
        error_log("DSN: $dsn");
        error_log("User: $user");

        try {
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new 
            \RuntimeException('Database connection error: ' . $e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    public function checkConnection(): bool
    {
        try {
            $this->pdo->query('SELECT 1');
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
