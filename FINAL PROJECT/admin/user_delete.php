<?php
require_once __DIR__ . '/../config.php';
require_admin();

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    flash('error', 'Invalid user ID.');
    header('Location: dashboard.php');
    exit;
}

$pdo = pdo();
$stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
$stmt->execute([$id]);
flash('success', 'User and related visits deleted.');
header('Location: dashboard.php');
exit;
