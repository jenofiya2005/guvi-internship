<?php

header("Content-Type: application/json");

require __DIR__ . "/db_mysql.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method"
    ]);
    exit;
}

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

if ($name === "" || $email === "" || $password === "") {
    echo json_encode([
        "success" => false,
        "message" => "All fields are required"
    ]);
    exit;
}

try {

    // Check whether email already exists
    $check = $conn->prepare(
        "SELECT id FROM users WHERE email = ?"
    );

    $check->execute([$email]);

    if ($check->fetch()) {
        echo json_encode([
            "success" => false,
            "message" => "Email already registered"
        ]);
        exit;
    }

    // Hash password
    $hashedPassword = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    // Insert user
    $stmt = $conn->prepare(
        "INSERT INTO users (name, email, password)
         VALUES (?, ?, ?)"
    );

    $stmt->execute([
        $name,
        $email,
        $hashedPassword
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Registration successful!"
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}

?>
