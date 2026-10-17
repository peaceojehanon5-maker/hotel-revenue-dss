# Hotel Revenue Decision Support System

**Peace Ojehanon** · Glasgow, UK · [LinkedIn](https://www.linkedin.com/in/peace-ojehanon) · peaceojehanon5@gmail.com

My **BSc Computer Science final-year project (Babcock University, 2018)**,
built by a group of three that I led. It is a PHP and MySQL web app for hotel
revenue management: staff record bookings, damages, expenses and staff issues,
and the manager's dashboard pairs each chart with a suggested decision, such
as the price each room type should go for based on monthly bookings. The
project was graded A.

My part was leading the group, editing and reviewing the report, helping with
the coding, and doing the final code review before our presentation. The app
ran locally on XAMPP. It was never used by a real hotel, and the data behind
the charts is randomly generated.

## What it does

- **Three user roles.** Records clerk (`R`), manager (`M`) and admin (`A`), each
  taken to the screens relevant to them after signing in.
- **Records.** Forms for bookings, damages, expenses and staff issues, saved to
  a MySQL database.
- **Manager dashboard.** Charts of the recorded data, each with a suggested
  decision beside it.

## Stack

PHP · MySQL · HTML, CSS and JavaScript · a Bootstrap admin template · jQuery ·
Chart.js. No framework: plain PHP, with a small `core/` folder for the database
connection, sign-in and the chart endpoints.

## Run it locally

1. Install [XAMPP](https://www.apachefriends.org/) (or any PHP and MySQL stack)
   and start Apache and MySQL.
2. Download this repo and unzip `hotel-revenue-dss.zip`. The zip holds the
   complete app. The files at the top level of this repo are only the page
   scripts, without the `core/` folder and the front-end assets they need.
3. Create a database called `dss_db` and import `dss_db.sql` into it
   (for example through phpMyAdmin at `localhost/phpmyadmin`).
4. Copy the unzipped `hotel-revenue-dss` folder into your web root (XAMPP:
   `htdocs/hotel-revenue-dss`).
5. The database settings default to a stock XAMPP install (`root`, no
   password). If yours differ, set `DB_HOST`, `DB_USER`, `DB_PASSWORD` and
   `DB_NAME` as environment variables (`.env.example` lists them).
6. Visit `http://localhost/hotel-revenue-dss/` and sign in.

### Demo accounts

The seed data creates three demo accounts, all with the password `demo1234`:

| Role | Email | Password |
|------|-------|----------|
| Manager | `manager@example.com` | `demo1234` |
| Records clerk | `records@example.com` | `demo1234` |
| Admin | `admin@example.com` | `demo1234` |

Change these before putting anything real behind the app.

## What changed for publishing (June 2026)

The code is the 2018 project, with these changes made in June 2026 before
putting it online:

- Sign-in, registration and the chart endpoints (`core/login.php`,
  `core/register.php` and `core/control.php`) use **prepared statements**. The
  2018 versions built SQL from `$_GET` and `$_POST` values, including a
  `DELETE FROM users` reachable from a plain link.
- That delete is now **POST only and limited to a signed-in manager**, and the
  chart endpoints check the session before returning data.
- Passwords are stored with **`password_hash()` (bcrypt)** and checked with
  `password_verify()`; an old md5 hash is upgraded at the next sign-in. The
  2018 version used plain md5.
- Database credentials come from **environment variables**, not the source.
- Connection errors are logged on the server instead of shown on the page.

Everything else is unchanged from 2018. In particular, `core/controller.php`
(which saves the bookings, damages, expenses and issues forms) and
`core/admin.php` (the admin sign-in) still build SQL straight from form values.
Treat this as a student project, not production software.

## Layout

```
index.php            sign-in screen
home.php             manager dashboard (charts and suggested decisions)
bookings.php, damage.php, expense.php, issue.php    records screens
admin.php            admin panel
dss_db.sql           schema, randomly generated sample data and demo accounts
hotel-revenue-dss.zip    the complete app, including:
  core/              database connection, sign-in, registration, chart endpoints
  css/ js/ img/ fonts/ vendors/    front-end assets (Bootstrap template, Chart.js)
```
