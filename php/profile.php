<?php

header('Content-Type: application/json');
require __DIR__ . '/db.php'; // MongoDB connection ($users collection)

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit;
}

$action = $_POST["action"] ?? "";
$email = trim($_POST["email"] ?? "");

if ($email === "") {
    echo json_encode(["success" => false, "message" => "Email is required"]);
    exit;
}

try {

    if ($action === "get") {

        $profile = $users->findOne(["email" => $email]);

        if ($profile) {
            echo json_encode([
                "success" => true,
                "data" => [
                    "name" => $profile["name"] ?? "",
                    "age" => $profile["age"] ?? "",
                    "dob" => $profile["dob"] ?? "",
                    "phone" => $profile["phone"] ?? ""
                ]
            ]);
        } else {
            echo json_encode(["success" => true, "data" => null]);
        }

    } elseif ($action === "save") {

        $name = trim($_POST["name"] ?? "");
        $age = trim($_POST["age"] ?? "");
        $dob = trim($_POST["dob"] ?? "");
        $phone = trim($_POST["phone"] ?? "");

        $users->updateOne(
            ["email" => $email],
            [
                '$set' => [
                    "email" => $email,
                    "name" => $name,
                    "age" => $age,
                    "dob" => $dob,
                    "phone" => $phone,
                    "updated_at" => new MongoDB\BSON\UTCDateTime()
                ]
            ],
            ["upsert" => true]
        );

        echo json_encode(["success" => true, "message" => "Profile saved successfully!"]);

    } else {
        echo json_encode(["success" => false, "message" => "Invalid action"]);
    }

} catch (Throwable $e) {
    echo json_encode(["success" => false, "message" => "MongoDB Error: " . $e->getMessage()]);
}

?>