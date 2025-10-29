<?php
// public/list.php
declare(strict_types=1);
require __DIR__ . '/../app/config.php';
require __DIR__ . '/../app/common.php';

// Fetch all contacts
$stmt = $pdo->query('SELECT id, name, email, phone, message, created_at FROM contacts ORDER BY created_at DESC');
$contacts = $stmt->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Contact Entries</title>
  <link rel="stylesheet" href="/assets/css/output.css">
</head>
<body>

  <?php include __DIR__ . '/../app/header.php'; ?>

  <main class="main">
    <div class="container-large">
    <div class="flex items-center justify-between mb-8">
      <h1 class="text-3xl font-bold text-[var(--color-brand)]">Saved Entries</h1>
    </div>

    <?php if (empty($contacts)): ?>
      <p class="text-gray-600">No entries found yet.</p>
    <?php else: ?>
      <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-100">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
              <th class="text-left px-4 py-3 font-semibold text-gray-700">#</th>
              <th class="text-left px-4 py-3 font-semibold text-gray-700">Name</th>
              <th class="text-left px-4 py-3 font-semibold text-gray-700">Email</th>
              <th class="text-left px-4 py-3 font-semibold text-gray-700">Phone</th>
              <th class="text-left px-4 py-3 font-semibold text-gray-700">Message</th>
              <th class="text-left px-4 py-3 font-semibold text-gray-700">Created</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($contacts as $c): ?>
              <tr class="border-b last:border-0 hover:bg-gray-50">
                <td class="px-4 py-3 text-gray-500"><?= (int)$c['id'] ?></td>
                <td class="px-4 py-3 font-medium"><?= htmlspecialchars($c['name'], ENT_QUOTES) ?></td>
                <td class="px-4 py-3 text-blue-700"><?= htmlspecialchars($c['email'], ENT_QUOTES) ?></td>
                <td class="px-4 py-3"><?= htmlspecialchars($c['phone'], ENT_QUOTES) ?></td>
                <td class="px-4 py-3 text-gray-700 max-w-[300px] truncate"><?= htmlspecialchars($c['message'], ENT_QUOTES) ?></td>
                <td class="px-4 py-3 text-gray-500 whitespace-nowrap"><?= htmlspecialchars($c['created_at'], ENT_QUOTES) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
            </div>
  </main>

  <?php include __DIR__ . '/../app/footer.php'; ?>

</body>
</html>