<?php
// public/handle.php
declare(strict_types=1);

require __DIR__ . '/../app/config.php';
require __DIR__ . '/../app/common.php';

// Only allow POST requests
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
  http_response_code(405);
  exit('Method Not Allowed');
}

// CSRF validation (optional — disable if not needed)
if (!csrf_check($_POST['csrf'] ?? '')) {
  flash_set('errors', ['Your session expired or the form is invalid. Please try again.']);
  header('Location: /');
  exit;
}

// Honeypot anti-bot check
if (!empty($_POST['website'] ?? '')) {
  flash_set('success', 'Thank you! Your message has been received.');
  header('Location: /');
  exit;
}

// Collect and sanitize inputs
$name    = trim((string)($_POST['name'] ?? ''));
$email   = trim((string)($_POST['email'] ?? ''));
$phone   = trim((string)($_POST['phone'] ?? ''));
$message = trim((string)($_POST['message'] ?? ''));

// Validation
$errors = [];

if ($name === '' || mb_strlen($name) < 2) {
  $errors[] = 'Please enter your name.';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors[] = 'Please enter a valid email address.';
}

// South African phone number validation
if (!preg_match('/^(?:\+27|0)[6-8][0-9]{8}$/', $phone)) {
  $errors[] = 'Please enter a valid South African phone number.';
}

if ($message === '' || mb_strlen($message) < 10) {
  $errors[] = 'Your message must be at least 10 characters long.';
}

// Redirect back with errors
if ($errors) {
  flash_set('errors', $errors);
  flash_set('old', compact('name', 'email', 'phone', 'message'));
  header('Location: /');
  exit;
}

// Store user agent (optional analytics info)
$ua = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255);

// Insert safely using PDO prepared statements
try {
  $stmt = $pdo->prepare("
    INSERT INTO contacts (name, email, phone, message, user_agent)
    VALUES (:name, :email, :phone, :message, :ua)
  ");
  $stmt->execute([
    ':name'    => $name,
    ':email'   => $email,
    ':phone'   => $phone,
    ':message' => $message,
    ':ua'      => $ua,
  ]);

  flash_set('success', 'Thank you! Your message has been received.');
  header('Location: /');
  exit;

} catch (Throwable $e) {
  if (APP_DEBUG) {
    http_response_code(500);
    echo '<pre>DB error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '</pre>';
  } else {
    flash_set('errors', ['Something went wrong. Please try again later.']);
    header('Location: /');
  }
  exit;
}