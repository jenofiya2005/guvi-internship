<?php

header('Content-Type: application/json');
require __DIR__ . '/db_mysql.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit;
}

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

if ($name === "" || $email === "" || $password === "") {
    echo json_encode(["success" => false, "message" => "All fields are required"]);
    exit;
}

try {
    $checkStmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->execute([$email]);

    if ($checkStmt->fetch()) {
        echo json_encode(["success" => false, "message" => "Email already registered"]);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $insertStmt = $pdo->prepare(
        "INSERT INTO users (name, email, password) VALUES (?, ?, ?)"
    );
    $insertStmt->execute([$name, $email, $hashedPassword]);

    echo json_encode(["success" => true, "message" => "Registration successful!"]);

} catch (Throwable $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}

?>