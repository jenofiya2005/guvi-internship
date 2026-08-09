<?php
header('Content-Type: text/plain');

echo "=== DEBUG INFO ===\n\n";

echo "__DIR__ of this script: " . __DIR__ . "\n";
echo "DOCUMENT_ROOT: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "SCRIPT_FILENAME: " . $_SERVER['SCRIPT_FILENAME'] . "\n\n";

echo "=== Searching for redis.php files ===\n";
$search = shell_exec('find /var/www/html -name "redis.php" 2>&1');
echo $search ?: "shell_exec disabled or not found\n";

echo "\n=== Searching for login.php files ===\n";
$search2 = shell_exec('find /var/www/html -name "login.php" 2>&1');
echo $search2 ?: "shell_exec disabled or not found\n";

echo "\n=== Content of /var/www/html/php/redis.php (if exists) ===\n";
if (file_exists('/var/www/html/php/redis.php')) {
    echo file_get_contents('/var/www/html/php/redis.php');
} else {
    echo "FILE DOES NOT EXIST at this path\n";
}

echo "\n=== Content of /var/www/html/redis.php (if exists) ===\n";
if (file_exists('/var/www/html/redis.php')) {
    echo file_get_contents('/var/www/html/redis.php');
} else {
    echo "FILE DOES NOT EXIST at this path\n";
}

echo "\n=== Full directory listing of /var/www/html ===\n";
print_r(scandir('/var/www/html'));

echo "\n=== Full directory listing of /var/www/html/php (if exists) ===\n";
if (is_dir('/var/www/html/php')) {
    print_r(scandir('/var/www/html/php'));
} else {
    echo "NO php/ FOLDER FOUND\n";
}
?>