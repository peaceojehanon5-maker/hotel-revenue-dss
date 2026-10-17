<?php
/**
 * Registration handler.
 *
 * Hardening:
 *   - parameterised duplicate-email check and INSERT;
 *   - passwords stored with password_hash() (bcrypt), never md5;
 *   - validation now stops on the first failure (the original fell through
 *     and could insert mismatched passwords).
 */
declare(strict_types=1);

require_once __DIR__ . '/controller.php';

$name  = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$pass1 = $_POST['password'] ?? '';
$pass2 = $_POST['password2'] ?? '';
$type  = $_POST['type'] ?? '';

if ($name === '' || $email === '' || $pass1 === '' || $pass2 === '') {
    exit('Please fill in all fields.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit('Please enter a valid email address.');
}
if (strlen($pass1) < 7) {
    exit('Password is too weak (minimum 7 characters).');
}
if ($pass1 !== $pass2) {
    exit("Passwords don't match.");
}
if (!in_array($type, ['R', 'M'], true)) {
    exit('Invalid account type.');
}

// Already registered?
$check = $con->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
$check->bind_param('s', $email);
$check->execute();
if ($check->get_result()->num_rows > 0) {
    exit('That email address is already registered. Try another.');
}

$hash = password_hash($pass1, PASSWORD_DEFAULT);
$ins  = $con->prepare('INSERT INTO users (name, email, password, type) VALUES (?, ?, ?, ?)');
$ins->bind_param('ssss', $name, $email, $hash, $type);
$ins->execute();

echo '<b>Registration successful.</b>';
