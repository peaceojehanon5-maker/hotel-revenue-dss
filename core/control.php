<?php
/**
 * Hotel Revenue DSS: application logic and chart/AJAX endpoints.
 *
 * Security hardening applied for publication (the original was an
 * undergraduate project, 2018):
 *   - every query uses prepared statements (no string-interpolated SQL);
 *   - state-changing and data-exposing endpoints require an authenticated
 *     manager session;
 *   - the user-delete action is POST-only (was a GET link, i.e. trivially
 *     CSRF-able and injectable);
 *   - year parameters are validated as integers.
 */
declare(strict_types=1);
session_start();

require_once __DIR__ . '/conn.php';

/** Reject anyone who isn't a signed-in manager. */
function require_manager(): void
{
    if (!isset($_SESSION['userData']) || ($_SESSION['userData']['type'] ?? '') !== 'M') {
        http_response_code(403);
        header('Content-Type: application/json');
        exit(json_encode(['error' => 'Not authorised']));
    }
}

/** Accept only a plausible 4-digit year; anything else becomes 0 (no rows). */
function valid_year($value): int
{
    $year = (int) $value;
    return ($year >= 1900 && $year <= 2100) ? $year : 0;
}

header('Content-Type: application/json');

/* ---- Delete a user (manager only, POST only) ---------------------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId'])) {
    require_manager();
    $id   = (int) $_POST['userId'];
    $stmt = $con->prepare('DELETE FROM users WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    exit(json_encode(['deleted' => $stmt->affected_rows]));
}

/* ---- Revenue vs. salary line chart -------------------------------------- */
if (isset($_GET['lineYear'])) {
    require_manager();
    $year = valid_year($_GET['lineYear']);

    $revenue = [];
    $stmt = $con->prepare(
        'SELECT SUM(rooms.price) AS pr
           FROM bookings
           JOIN rooms ON bookings.room_id = rooms.id
          WHERE YEAR(bookings.date) = ?
          GROUP BY MONTH(bookings.date)'
    );
    $stmt->bind_param('i', $year);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_object()) {
        $revenue[] = $row->pr;
    }

    // Total monthly salary cost is the same each month (no user input here).
    $salaryRow   = $con->query('SELECT SUM(salary) AS salary FROM staffs')->fetch_object();
    $monthlyCost = $salaryRow->salary ?? 0;
    $salary      = array_fill(0, 12, $monthlyCost);

    exit(json_encode(['revenue' => $revenue, 'salary' => $salary]));
}

/* ---- Issues-per-staff pie chart ----------------------------------------- */
if (isset($_GET['loadPie'])) {
    require_manager();
    $rows  = [];
    $query = $con->query(
        'SELECT staffs.name, staffs.salary, COUNT(issues.stafff_id) AS ish
           FROM staffs
           JOIN issues ON staffs.id = issues.stafff_id
          GROUP BY staffs.id, staffs.name, staffs.salary'
    );
    while ($row = $query->fetch_object()) {
        $rows[] = [
            'name'   => ucfirst($row->name) . ' => ' . number_format((float) $row->salary),
            'salary' => $row->salary,
            'ish'    => $row->ish,
        ];
    }
    exit(json_encode($rows));
}

/* ---- Bookings per room type, by month ----------------------------------- */
if (isset($_GET['year'])) {
    require_manager();
    $year = valid_year($_GET['year']);

    $executive = [];
    $regular   = [];
    $stmt = $con->prepare(
        'SELECT room_id, COUNT(id) AS books
           FROM bookings
          WHERE YEAR(date) = ?
          GROUP BY MONTH(date), room_id'
    );
    $stmt->bind_param('i', $year);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_object()) {
        if ((int) $row->room_id === 1) {
            $executive[] = $row->books;
        } else {
            $regular[] = $row->books;
        }
    }
    exit(json_encode(['Executive' => $executive, 'Regular' => $regular]));
}

/* ---- Damage cost per month ---------------------------------------------- */
if (isset($_GET['getDam'])) {
    require_manager();
    $year = valid_year($_GET['getDam']);

    $costs = [];
    $stmt = $con->prepare(
        'SELECT SUM(cost) AS tcost
           FROM damages
          WHERE YEAR(date) = ?
          GROUP BY MONTH(date)'
    );
    $stmt->bind_param('i', $year);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_object()) {
        $costs[] = $row->tcost;
    }
    exit(json_encode($costs));
}
