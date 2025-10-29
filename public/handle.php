<?php
declare(strict_types=1);
require __DIR__ . '/../app/config.php';
require __DIR__ . '/../app/common.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /');
  exit;
}

// Honeypot (anti-bot).
if (!empty($_POST['website'] ?? '')) {
  flash_set('success', 'Thanks! Your message was received.');
  header('Location: /');
  exit;
}

// CSRF
$csrf = (string)($_POST['csrf'] ?? '');
if (!csrf_verify($csrf)) {
  flash_set('errors', ['Invalid session token. Please try again.']);
  header('Location: /');
  exit;
}

// Collect
$name    = (string)($_POST['name'] ?? '');
$email   = (string)($_POST['email'] ?? '');
$phone   = (string)($_POST['phone'] ?? '');
$message = (string)($_POST['message'] ?? '');

// Validate
$errors = [];
if ($e = validate_name($name))        $errors[] = $e;
if ($e = validate_email($email))      $errors[] = $e;
if ($e = validate_sa_phone($phone))   $errors[] = $e;
if ($e = validate_message($message))  $errors[] = $e;

if ($errors) {
  flash_set('errors', $errors);
  flash_set('old', compact('name','email','phone','message'));
  header('Location: /');
  exit;
}

// Insert
$ip = ip_to_binary($_SERVER['REMOTE_ADDR'] ?? null);
$ua = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 512);
$phone_norm = normalize_phone($phone);

$stmt = $pdo->prepare('INSERT INTO contacts (name,email,phone,message,ip,user_agent) VALUES (?,?,?,?,?,?)');
$stmt->execute([$name, $email, $phone_norm, $message, $ip, $ua]);

flash_set('success', 'Thanks! Your message was received.');
header('Location: /');
exit;