<?php
 
require __DIR__ . '/../vendor/autoload.php';
 
$redis = new Predis\Client([
    'scheme'   => 'tls',
    'host'     => getenv('REDIS_HOST') ?: '127.0.0.1',
    'port'     => getenv('REDIS_PORT') ?: 6379,
    'username' => getenv('REDIS_USER') ?: null,
    'password' => getenv('REDIS_PASSWORD') ?: null,
    'ssl'      => [
        'verify_peer'      => false,
        'verify_peer_name' => false,
    ],
]);
 
?>
 
