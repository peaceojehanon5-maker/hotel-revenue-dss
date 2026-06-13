# Hotel Revenue Decision-Support System

**Peace Ojehanon** · Glasgow, UK · [LinkedIn](https://www.linkedin.com/in/peace-ojehanon) · peaceojehanon5@gmail.com

A full-stack web application that helps a hotel make pricing and staffing
decisions by putting revenue, bookings, maintenance costs and staff salary
against each other on one dashboard. Built as my **BSc Computer Science
final-year project (Babcock University, 2018)** and preserved here, with the
security-critical code modernised for public hosting (see *Security* below).

The dashboard answers questions a duty manager actually asks: *are we making
more than we're spending each month? which room type is filling up? where is
the maintenance budget going? who's logging the most issues?*

## What it does

- **Role-based access** — three account types: records clerk (`R`), manager
  (`M`) and admin (`A`), each landing on the screens relevant to them.
- **Bookings & rooms** — record bookings against room types and rates.
- **Revenue vs. cost** — a monthly line chart comparing booking revenue with
  total salary cost for a chosen year.
- **Occupancy** — bookings per room type, by month.
- **Maintenance** — damage/expense logging with a cost-per-month view.
- **Issues** — a per-staff breakdown of logged issues.

## Stack

PHP · MySQL · JavaScript · Bootstrap · Chart.js. No framework — plain PHP with
a small `core/` layer for connection, auth and the chart endpoints.

## Run it locally

1. Install [XAMPP](https://www.apachefriends.org/) (or any PHP + MySQL stack)
   and start Apache and MySQL.
2. Create a database called `dss_db` and import `dss_db.sql` into it
   (e.g. via phpMyAdmin at `localhost/phpmyadmin`).
3. Copy this folder into your web root (XAMPP: `htdocs/hotel-revenue-dss`).
4. Set your database credentials — copy `.env.example` to `.env` and edit, or
   export `DB_HOST`, `DB_USER`, `DB_PASSWORD`, `DB_NAME` in your environment.
   The defaults match a stock XAMPP install (`root`, no password).
5. Visit `http://localhost/hotel-revenue-dss/` and sign in.

### Demo accounts

The seed data creates three demo accounts, all with the password `demo1234`:

| Role | Email | Password |
|------|-------|----------|
| Manager | `manager@example.com` | `demo1234` |
| Records clerk | `records@example.com` | `demo1234` |
| Admin | `admin@example.com` | `demo1234` |

Change these before putting anything real behind the app.

## Security

This is preserved 2018 student code, so I've been explicit about what was
changed for publication rather than pretending it shipped this way:

**Hardened (in `core/`):**
- All database access uses **prepared statements** — the original interpolated
  `$_GET`/`$_POST` straight into SQL, including a `DELETE FROM users` reachable
  by a simple GET link.
- That delete is now **POST-only and restricted to an authenticated manager**,
  and every chart endpoint checks the session before returning data.
- Passwords are stored with **`password_hash()` (bcrypt)** and checked with
  `password_verify()`; any legacy md5 record is upgraded on next login. The
  original used bare md5.
- Database credentials come from the **environment**, not committed source.
- Connection errors are logged server-side instead of echoed to the page.

**Preserved as-is:** the page-level scripts (`bookings.php`, `expense.php`,
etc.) are the original coursework and still follow the older patterns. The
hardened `core/` shows how I'd write the data layer today; the front-end pages
are kept for honesty about where the project started. Treat this as a learning
artefact, not production software.

## Layout

```
index.php          login screen
home.php            manager dashboard (charts)
bookings.php …      records/clerk screens
admin.php           admin panel
core/               connection, auth (login/register), chart endpoints  ← hardened
dss_db.sql          schema + demo seed data
css/ js/ img/ fonts/ vendors/   front-end assets (Bootstrap, Chart.js)
```
