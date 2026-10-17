<?php
/**
 * Database connection (mysqli).
 *
 * Credentials are read from environment variables so nothing sensitive is
 * committed to the repository. For local development, copy `.env.example`
 * to `.env` and load it, or simply export the variables in your shell.
 * Sensible XAMPP defaults are used as a fallback.
 */
declare(strict_types=1);

// Turn mysqli errors into exceptions so we can fail safely without
// leaking SQL or connection details to the browser.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$DB_HOST = getenv('DB_HOST') ?: '127.0.0.1';
$DB_USER = getenv('DB_USER') ?: 'root';
$DB_PASS = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : '';
$DB_NAME = getenv('DB_NAME') ?: 'dss_db';

try {
    $con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    mysqli_set_charset($con, 'utf8mb4');
} catch (\mysqli_sql_exception $e) {
    // Log the real reason server-side; show the user something neutral.
    error_log('DB connection failed: ' . $e->getMessage());
    http_response_code(503);
    exit('Service temporarily unavailable. Please try again later.');
}
