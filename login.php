<?php

header('Content-Type: application/json');
require __DIR__ . '/db_mysql.php';
require __DIR__ . '/../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit;
}

$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

if ($email === "" || $password === "") {
    echo json_encode(["success" => false, "message" => "Email and password required"]);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($password, $user["password"])) {
        echo json_encode(["success" => false, "message" => "Invalid email or password"]);
        exit;
    }

    $token = bin2hex(random_bytes(32));

    $redis->setex("session:" . $token, 3600, json_encode([
        "id" => $user["id"],
        "name" => $user["name"],
        "email" => $user["email"]
    ]));

    echo json_encode([
        "success" => true,
        "message" => "Login successful!",
        "token" => $token,
        "user" => [
            "id" => $user["id"],
            "name" => $user["name"],
            "email" => $user["email"]
        ]
    ]);

} catch (Throwable $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}

?>
