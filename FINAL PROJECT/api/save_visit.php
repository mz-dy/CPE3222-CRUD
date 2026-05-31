<?php
require_once __DIR__ . '/../config.php';

function redirect_with(string $type, string $message): void {
    flash($type, $message);
    header('Location: ../index.php');
    exit;
}

$action         = $_POST['action']         ?? '';
$usc_id         = trim($_POST['usc_id']         ?? '');   // now submitted as name="usc_id" from usc_id_display
$first_name     = trim($_POST['first_name']     ?? '');
$middle_name     = trim($_POST['middle_name']     ?? '');
$last_name      = trim($_POST['last_name']      ?? '');
$barangay       = trim($_POST['barangay']       ?? '');
$city           = trim($_POST['city']           ?? '');
$province       = trim($_POST['province']       ?? '');
$contact_number = trim($_POST['contact_number'] ?? '');
$email          = trim($_POST['email']          ?? '');
$usertype       = trim($_POST['user_type']      ?? '');

$is_guest = ($usertype === 'Guest');

// USC users must supply an ID; guests must supply a name
if (!$is_guest && $usc_id === '') {
    redirect_with('error', 'ID number is required for Student, Faculty, or Staff.');
}
if ($is_guest && ($first_name === '' || $last_name === '')) {
    redirect_with('error', 'First and last name are required for guests.');
}

$pdo = pdo();

function record_visit(PDO $pdo, int $user_id, string $action): void {
    $stmt = $pdo->prepare('INSERT INTO visits (user_id, action, timestamp) VALUES (?, ?, NOW())');
    $stmt->execute([$user_id, $action]);
}

/**
 * Find a user row.
 * USC users  → look up by usc_id
 * Guest users → look up by first_name + last_name + user_type = 'Guest'
 */
function find_user(PDO $pdo, bool $is_guest, string $usc_id, string $first_name, string $last_name): array|false {
    if ($is_guest) {
        $stmt = $pdo->prepare(
            "SELECT id FROM users
              WHERE user_type = 'Guest'
                AND first_name = ?
                AND last_name  = ?
              LIMIT 1"
        );
        $stmt->execute([$first_name, $last_name]);
    } else {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE usc_id = ? LIMIT 1');
        $stmt->execute([$usc_id]);
    }
    return $stmt->fetch();
}

try {
    // ── REGISTER & SIGN IN ────────────────────────────────────────────────────
    if ($action === 'register') {
        foreach ([$first_name, $last_name, $barangay, $city, $province, $contact_number, $email] as $value) {
            if ($value === '') {
                redirect_with('error', 'Please complete all required fields.');
            }
        }

        $pdo->beginTransaction();

        $existing = find_user($pdo, $is_guest, $usc_id, $first_name, $last_name);

        if ($existing) {
            // Record already exists — just update contact details and sign in
            $user_id = (int)$existing['id'];
            $stmt = $pdo->prepare(
                'UPDATE users
                    SET barangay=?, city=?, province=?, contact_number=?, email=?
                  WHERE id=?'
            );
            $stmt->execute([$barangay, $city, $province, $contact_number, $email, $user_id]);
        } else {
            // New user — insert full record
            $stmt = $pdo->prepare(
                'INSERT INTO users
                    (usc_id, user_type, first_name, last_name, barangay, city, province, contact_number, email)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
            );
            $stmt->execute([
                $is_guest ? null : $usc_id,
                $usertype,
                $first_name,
                $last_name,
                $barangay,
                $city,
                $province,
                $contact_number,
                $email,
            ]);
            $user_id = (int)$pdo->lastInsertId();
        }

        record_visit($pdo, $user_id, 'in');
        $pdo->commit();
        redirect_with('success', 'Registration completed and entry time recorded.');
    }

    // ── SIGN IN / SIGN OUT ────────────────────────────────────────────────────
    $user = find_user($pdo, $is_guest, $usc_id, $first_name, $last_name);

    if (!$user) {
        redirect_with('error', 'No matching record found. Please register first.');
    }

    $user_id = (int)$user['id'];

    if ($action === 'signin') {
        $stmt = $pdo->prepare(
            'SELECT action FROM visits WHERE user_id = ? ORDER BY timestamp DESC, id DESC LIMIT 1'
        );
        $stmt->execute([$user_id]);
        $last = $stmt->fetch();

        if ($last && $last['action'] === 'in') {
            redirect_with('error', 'This user is already signed in. Please sign out first.');
        }

        record_visit($pdo, $user_id, 'in');
        redirect_with('success', 'Sign-in successful. Entry time recorded.');
    }

    if ($action === 'signout') {
        $stmt = $pdo->prepare(
            'SELECT action FROM visits WHERE user_id = ? ORDER BY timestamp DESC, id DESC LIMIT 1'
        );
        $stmt->execute([$user_id]);
        $last = $stmt->fetch();

        if (!$last || $last['action'] === 'out') {
            redirect_with('error', 'No active sign-in found. Please sign in first.');
        }

        record_visit($pdo, $user_id, 'out');
        redirect_with('success', 'Sign-out successful. Exit time recorded.');
    }

    redirect_with('error', 'Invalid action.');

} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    redirect_with('error', 'Unable to process request. Please try again.');
}