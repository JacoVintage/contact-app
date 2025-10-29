<?php
declare(strict_types=1);

function e(?string $v): string { return htmlspecialchars((string)$v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }

function flash_set(string $key, $value): void { $_SESSION['flash'][$key] = $value; }
function flash_get(string $key, $default = null) {
  if (!isset($_SESSION['flash'][$key])) return $default;
  $v = $_SESSION['flash'][$key]; unset($_SESSION['flash'][$key]); return $v;
}

function csrf_token(): string {
  if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
  return $_SESSION['csrf'];
}
function csrf_verify(string $t): bool {
  return hash_equals($_SESSION['csrf'] ?? '', $t);
}

function ip_to_binary(?string $ip): ?string { $bin = $ip ? @inet_pton($ip) : false; return $bin === false ? null : $bin; }

function normalize_phone(string $p): string { return preg_replace('/[\\s\\-()]/', '', $p) ?? ''; }

function validate_name(string $name): ?string {
  $name = trim($name);
  if ($name === '') return 'Name is required.';
  if (mb_strlen($name) > 120) return 'Name is too long (max 120).';
  return null;
}
function validate_email(string $email): ?string {
  $email = trim($email);
  if ($email === '') return 'Email is required.';
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return 'Enter a valid email address.';
  return null;
}
function validate_sa_phone(string $phone): ?string {
  $p = normalize_phone($phone);
  if ($p === '') return 'Phone is required.';
  if (!preg_match('/^(?:\\+27|0)[1-9]\\d{8}$/', $p)) return 'Enter a valid South African phone (e.g. 0821234567 or +27821234567).';
  return null;
}
function validate_message(string $msg): ?string {
  $msg = trim($msg);
  if ($msg === '') return 'Message is required.';
  $len = mb_strlen($msg);
  if ($len < 10) return 'Message is too short (min 10 chars).';
  if ($len > 5000) return 'Message is too long (max 5000 chars).';
  return null;
}