<?php
/*require_once __DIR__ . '/../config.php';
header('Content-Type: application/json');

$usc_id = trim($_GET['usc_id'] ?? '');
if ($usc_id === '') {
    echo json_encode(['ok' => false, 'message' => 'Missing ID number']);
    exit;
}

$stmt = pdo()->prepare('SELECT * FROM users WHERE usc_id = ? LIMIT 1');
$stmt->execute([$usc_id]);
$user = $stmt->fetch();

echo json_encode([
    'ok' => (bool)$user,
    'user' => $user ?: null
]); */
header('Content-Type: application/json');

$usc_id = $_GET['usc_id'] ?? '';
$type   = $_GET['user_type'] ?? '';

// TEST CASE: hardcoded user
if ($type !== 'Guest' && $usc_id === '123') {
    echo json_encode([
        'ok' => true,
        'user' => [
            'usc_id' => '123',
            'first_name' => 'Juan',
            'last_name' => 'Cruz',
            'barangay' => 'Lahug',
            'city' => 'Cebu City',
            'province' => 'Cebu',
            'contact_number' => '09123456789',
            'email' => 'juan@example.com'
        ]
    ]);
    exit;
}

// GUEST TEST USER
if ($type === 'Guest' && $first === 'gre' && $last === 'rte') {
    echo json_encode([
        'ok' => true,
        'user' => [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'barangay' => 'Makati',
            'city' => 'Makati City',
            'province' => 'Metro Manila',
            'contact_number' => '09998887777',
            'email' => 'jane@example.com'
        ]
    ]);
    exit;
}

// default response
echo json_encode([
    'ok' => false,
    'user' => null
]);
