<?php

$host = "guvi-mysql-guvi-internship.e.aivencloud.com";
$port = "17046";
$db   = "defaultdb";
$user = "avnadmin";
$pass = "AVNS_x3Ryy7wvkdemeaTp9nF";

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "DB connection failed: " . $e->getMessage()]);
    exit;
}

?>