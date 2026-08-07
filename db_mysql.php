<?php

$host = getenv("MYSQL_HOST");
$port = getenv("MYSQL_PORT");
$db   = getenv("MYSQL_DATABASE");
$user = getenv("MYSQL_USER");
$pass = getenv("MYSQL_PASSWORD");

try {

    $conn = new PDO(
        "mysql:host=" . $host . ";port=" . $port . ";dbname=" . $db . ";charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

} catch (PDOException $e) {

    die(json_encode([
        "success" => false,
        "message" => "DB connection failed: " . $e->getMessage()
    ]));

}
?>
