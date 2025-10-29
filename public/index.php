<?php
// public/index.php
declare(strict_types=1);
require __DIR__ . '/../app/config.php';
require __DIR__ . '/../app/common.php';

$errors = flash_get('errors', []);
$old = flash_get('old', ['name'=>'','email'=>'','phone'=>'','message'=>'']);
$success = flash_get('success');
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Contact Form</title>

  <!-- Tailwind (CDN) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          container: { center: true, padding: '1rem' }
        }
      }
    }
  </script>
</head>
<body class="bg-gray-50 text-gray-900">
  <main class="container max-w-2xl py-8">
    <h1 class="text-2xl font-semibold mb-4">Contact Us</h1>

    <?php if ($success): ?>
      <div class="mb-4 rounded border border-green-200 bg-green-50 p-4 text-green-800"><?= htmlspecialchars($success, ENT_QUOTES) ?></div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
      <div class="mb-4 rounded border border-red-200 bg-red-50 p-4 text-red-800">
        <p class="font-medium mb-2">Please fix the following:</p>
        <ul class="list-disc pl-5 space-y-1">
          <?php foreach ($errors as $err): ?>
            <li><?= htmlspecialchars($err, ENT_QUOTES) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <!-- form shell -->
    <form action="/handle.php" method="post" class="space-y-4" novalidate>
      <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES) ?>">
      <!-- Honeypot -->
      <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">

      <div>
        <label class="block text-sm font-medium mb-1" for="name">Name *</label>
        <input id="name" name="name" type="text" value="<?= htmlspecialchars($old['name'], ENT_QUOTES) ?>"
               class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" maxlength="120">
      </div>

      <div>
        <label class="block text-sm font-medium mb-1" for="email">Email *</label>
        <input id="email" name="email" type="email" value="<?= htmlspecialchars($old['email'], ENT_QUOTES) ?>"
               class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
      </div>

      <div>
        <label class="block text-sm font-medium mb-1" for="phone">Phone (SA) *</label>
        <input id="phone" name="phone" type="tel" value="<?= htmlspecialchars($old['phone'], ENT_QUOTES) ?>"
               placeholder="0821234567 or +27821234567"
               class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
        <p class="text-xs text-gray-500 mt-1">Format: 0XXXXXXXXX or +27XXXXXXXXX</p>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1" for="message">Message *</label>
        <textarea id="message" name="message" rows="6"
                  class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"><?= htmlspecialchars($old['message'], ENT_QUOTES) ?></textarea>
      </div>

      <button type="submit"
              class="inline-flex items-center rounded bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
        Submit
      </button>
    </form>
  </main>
</body>
</html>