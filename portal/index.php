<?php
declare(strict_types=1);
session_start();
require dirname(__DIR__) . '/config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $connection = database();
    if ($connection !== null) {
        $statement = $connection->prepare('SELECT id, full_name, password_hash FROM employees WHERE email = :email AND active = 1 LIMIT 1');
        $statement->execute([':email' => $email]);
        $employee = $statement->fetch();
        if ($employee && password_verify($password, $employee['password_hash'])) {
            $_SESSION['employee_name'] = $employee['full_name'];
            header('Location: index.php');
            exit;
        }
    }
    $error = 'Those details did not match an active employee account.';
}

$signedIn = isset($_SESSION['employee_name']);
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Employee portal | Zenara Group</title><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="../assets/styles.css"></head><body class="portal-page"><main class="portal-shell"><a class="brand" href="../"><span class="brand-mark">Z</span><span>zenara<span class="brand-dot">.</span></span></a><?php if ($signedIn): ?><section class="portal-card"><p class="eyebrow"><span></span> Employee portal</p><h1>Good morning,<br><em><?= e((string) $_SESSION['employee_name']) ?>.</em></h1><p>Your workspace is ready. Portal tools can be added here for dispatch, delivery updates, and team documents.</p><a class="button button-dark" href="?logout=1">Sign out <span>↗</span></a></section><?php else: ?><section class="portal-card"><p class="eyebrow"><span></span> Employee portal</p><h1>Welcome<br><em>back.</em></h1><p>Sign in to access your Zenara workspace.</p><?php if ($error !== ''): ?><p class="form-error"><?= e($error) ?></p><?php endif; ?><form method="post"><label>Work email<input type="email" name="email" required autocomplete="username"></label><label>Password<input type="password" name="password" required autocomplete="current-password"></label><button class="button button-dark" type="submit">Sign in <span>↗</span></button></form></section><?php endif; ?><a class="portal-back" href="../">← Back to zenaragroup.co.ke</a></main></body></html>