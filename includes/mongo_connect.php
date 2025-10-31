<?php
function loadEnv($path = __DIR__ . '/../.env') {
    if (!file_exists($path)) return;
    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}
loadEnv();

$user = $_ENV['MONGO_USER'] ?? '';
$pass = $_ENV['MONGO_PASS'] ?? '';
$host = $_ENV['MONGO_HOST'] ?? 'localhost';
$uri = "mongodb+srv://{$user}:{$pass}@{$host}/?retryWrites=true&w=majority&tlsAllowInvalidCertificates=true";

$manager = new MongoDB\Driver\Manager($uri);
