<?php
/**
 * Login handler.
 *
 * Hardening:
 *   - parameterised lookup by email (no SQL string interpolation);
 *   - passwords verified with password_verify();
 *   - legacy md5 hashes from the original 2018 data are accepted once and
 *     transparently upgraded to a modern bcrypt hash on next login.
 */
declare(strict_types=1);

require_once __DIR__ . '/conn.php';
require_once __DIR__ . '/controller.php';

if (empty($_POST['email']) || empty($_POST['password'])) {
    exit('All fields are required.');
}

$email    = trim($_POST['email']);
$password = $_POST['password'];

$stmt = $con->prepare('SELECT id, name, email, type, password FROM users WHERE email = ? LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    exit('User not found. Please check your details.');
}

$stored = $user['password'];
$ok     = false;

if (password_verify($password, $stored)) {
    $ok = true;
} elseif (preg_match('/^[a-f0-9]{32}$/i', $stored) && hash_equals($stored, md5($password))) {
    // Legacy md5 record: accept once, then re-hash properly.
    $ok    = true;
    $newel = password_hash($password, PASSWORD_DEFAULT);
    $up    = $con->prepare('UPDATE users SET password = ? WHERE id = ?');
    $up->bind_param('si', $newel, $user['id']);
    $up->execute();
}

if (!$ok) {
    exit('User not found. Please check your details.');
}

session_regenerate_id(true);
$_SESSION['userData'] = [
    'id'    => $user['id'],
    'name'  => $user['name'],
    'email' => $user['email'],
    'type'  => $user['type'],
];

if ($user['type'] === 'R') {
    header('Location: ../bookings.php');
} elseif ($user['type'] === 'M') {
    header('Location: ../home.php');
} else {
    header('Location: ../index.php');
}
exit;
