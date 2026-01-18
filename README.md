# Workshop 8 - Student CRUD with MVC + Blade

## Setup
1. From project root (`workshop8`), initialize composer (optional):
   - `composer init` (accept defaults)
2. Install Blade and required packages:
   - `composer require illuminate/view illuminate/filesystem illuminate/events`

3. Ensure your database is set up and `db.php` points to `school_db`.

### Sample SQL
```sql
CREATE DATABASE school_db;
USE school_db;

CREATE TABLE students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  course VARCHAR(255) NOT NULL
);
```

## Run
- Open in browser: `http://localhost/workshop8/public/`

## Notes
- If composer dependencies are missing, `public/index.php` will prompt you to run the `composer require` command.
- Files of interest:
  - `app/models/Student.php`
  - `app/controllers/StudentController.php`
  - `app/views/layouts/master.blade.php`
  - `app/views/students/*.blade.php`
  - `public/index.php`
