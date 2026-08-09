<?php

header('Content-Type: text/plain');
require __DIR__ . '/db_mysql.php';

try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    echo "Table created successfully!";
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage();
}

?>