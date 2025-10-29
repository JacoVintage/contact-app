<?php
// app/config.php
declare(strict_types=1);

const APP_DEBUG = true;

// Force TCP (avoids socket confusion)
const DB_HOST = '127.0.0.1';
const DB_PORT = 3306;
const DB_NAME = 'contact_app';
const DB_USER = 'root';
const DB_PASS = 'wcu01';
const DB_CHARSET = 'utf8mb4';

// Session
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_set_cookie_params([
    'lifetime' => 0, 'path' => '/', 'domain' => '',
    'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
    'httponly' => true, 'samesite' => 'Lax',
  ]);
  session_start();
}

// Headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: no-referrer-when-downgrade');

$dsnTcp = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s', DB_HOST, DB_PORT, DB_NAME, DB_CHARSET);
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => false,
];

try {
  $pdo = new PDO($dsnTcp, DB_USER, DB_PASS, $options);
} catch (Throwable $e) {
  http_response_code(500);
  echo APP_DEBUG
    ? '<pre>PDO connect error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '</pre>'
    : 'Database connection failed.';
  exit;
}