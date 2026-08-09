try {
    require __DIR__ . '/redis.php';
    $redis->setex("session:" . $token, 3600, json_encode([
        "id" => $user["id"],
        "name" => $user["name"],
        "email" => $user["email"]
    ]));
} catch (Throwable $e) {
    // Redis not available in production, skip silently
}