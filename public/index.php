<?php
// public/index.php
declare(strict_types=1);
require __DIR__ . '/../app/config.php';
require __DIR__ . '/../app/common.php';

$errors  = flash_get('errors', []);
$old     = flash_get('old', ['name'=>'','email'=>'','phone'=>'','message'=>'']);
$success = flash_get('success');
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Contact Form</title>

  <link rel="stylesheet" href="/assets/css/output.css">
</head>
<body>

  <?php include __DIR__ . '/../app/header.php'; ?>

  <main class="main">
    <div class="container">
    <h1 class="heading-primary">Contact Us</h1>

    <?php if ($success): ?>
      <div class="alert-success">
        <?= htmlspecialchars($success, ENT_QUOTES) ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
      <div class="alert-error">
        <p class="form__error-heading">Please fix the following:</p>
        <ul class="form__error-list">
          <?php foreach ($errors as $err): ?>
            <li><?= htmlspecialchars($err, ENT_QUOTES) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form action="/handle.php" method="post" class="form" novalidate>
      <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES) ?>">
      <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">

      <div class="form__group">
        <label for="name" class="label">Name *</label>
        <input id="name" name="name" type="text" maxlength="120"
               value="<?= htmlspecialchars($old['name'], ENT_QUOTES) ?>"
               class="input">
      </div>

      <div class="form__group">
        <label for="email" class="label">Email *</label>
        <input id="email" name="email" type="email"
               value="<?= htmlspecialchars($old['email'], ENT_QUOTES) ?>"
               class="input">
      </div>

      <div class="form__group">
        <label for="phone" class="label">Phone (SA) *</label>
        <input id="phone" name="phone" type="tel"
               value="<?= htmlspecialchars($old['phone'], ENT_QUOTES) ?>"
               placeholder="0821234567 or +27821234567"
               class="input">
        <p class="help">Format: 0XXXXXXXXX or +27XXXXXXXXX</p>
      </div>

      <div class="form__group">
        <label for="message" class="label">Message *</label>
        <textarea id="message" name="message" rows="6" class="textarea"><?= htmlspecialchars($old['message'], ENT_QUOTES) ?></textarea>
      </div>

      <button type="submit" class="btn-primary">Submit</button>
    </form>
          </div>
  </main>

  <?php include __DIR__ . '/../app/footer.php'; ?>

</body>
</html>