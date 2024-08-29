<?php

require_once __DIR__ . '/../../Database/DatabaseConnection.php';
require_once __DIR__ . '/../../config/config.php';

use Database\DatabaseConnection;

$config = require __DIR__ . '/../../config/config.php';
$dbConfig = $config['database'];

// Crear una instancia de la conexión a la base de datos
$database = new DatabaseConnection($dbConfig);
$pdo = $database->getConnection();

// Crear la tabla users
$sql = "
    CREATE TABLE IF NOT EXISTS users (
        id SERIAL PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        is_active BOOLEAN DEFAULT TRUE
    );
";

try {
    $pdo->exec($sql);
    echo "Table 'users' created successfully.\n";
} catch (PDOException $e) {
    echo "Error creating table: " . $e->getMessage() . "\n";
}
