# Simple Student Management System

A Laravel midterm project for managing student records with full CRUD operations (Create, Read, Update, Delete).

This project uses **SQLite** for the database (no MySQL server required).

## Requirements

- PHP 8.2 or higher (with SQLite extension enabled — included by default in Laragon)
- [Composer](https://getcomposer.org/)

## Setup Instructions

1. **Clone or extract** the project into your web directory (e.g. `c:\laragon\www\midterm-laravel`).

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Environment file:**
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```
   On Linux/macOS use `cp .env.example .env` instead of `copy`.

4. **Create the SQLite database file** (if it does not exist yet):
   ```bash
   type nul > database\database.sqlite
   ```
   On Linux/macOS: `touch database/database.sqlite`

5. **Run migrations** (and optional sample data):
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Start the development server:**
   ```bash
   php artisan serve
   ```

7. Open **http://127.0.0.1:8000/students** in your browser.

## Environment Configuration Checklist

Copy `.env.example` to `.env`. For **SQLite**, use these settings:

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

- Do **not** need `DB_HOST`, `DB_PORT`, `DB_USERNAME`, or `DB_PASSWORD` for SQLite.
- The file `database/database.sqlite` is created locally and is **not** included in Git (see `database/.gitignore`). Each machine must create it before migrating.
- `APP_URL` — optional; set to `http://127.0.0.1:8000` if needed.

Create the MySQL database before running `php artisan migrate`.

## Features

- Student list (Name, Email, Age)
- Add, edit, and delete students
- Form validation (unique email, valid age)
- Delete confirmation prompt
- Success messages after actions

## Submitted By

- Eldrian Aspa (Leader)
- Tristan Bugarin
- Nicollette Lasquite
- Mikyla Lanorio

