<?php

$host = getenv("MYSQL_HOST");
$port = getenv("MYSQL_PORT");
$database = getenv("MYSQL_DATABASE");
$user = getenv("MYSQL_USER");
$password = getenv("MYSQL_PASSWORD");

try {

    $conn = new PDO(
        "mysql:host=$host;port=$port;dbname=$database",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );

} catch (PDOException $e) {

    die(json_encode([
        "success" => false,
        "message" => "DB connection failed: " . $e->getMessage()
    ]));

}
?>
