<?php
// app/common.php
declare(strict_types=1);

// Ensure session is started (config.php normally does this)
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

/* CSRF HELPERS (stable, not one-time use) */

/**
 * Generate or return an existing CSRF token.
 */
function csrf_token(): string {
  if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf_token'];
}

/**
 * Validate a CSRF token. Keeps it persistent to avoid false negatives.
 */
function csrf_check(?string $token): bool {
  if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return false;
  }
  return hash_equals($_SESSION['csrf_token'], (string)$token);
}

/**
 * Store a temporary session flash message or array.
 */
function flash_set(string $key, mixed $value): void {
  $_SESSION['flash'][$key] = $value;
}

/**
 * Retrieve and remove a flash message.
 */
function flash_get(string $key, mixed $default = null): mixed {
  if (!isset($_SESSION['flash'][$key])) {
    return $default;
  }
  $value = $_SESSION['flash'][$key];
  unset($_SESSION['flash'][$key]);
  return $value;
}

/**
 * Escape output for safe HTML rendering.
 */
function e(?string $v): string {
  return htmlspecialchars((string)$v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}