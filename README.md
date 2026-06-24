# Lab05 - Training Center CRM

## Student Information

* Course: Web Development with PHP
* Lab: Lab05 - Database CRUD Application
* Student: NGO THUY QUYNH

---

## Project Overview

Training Center CRM is a simple PHP application built using:

* PHP 8+
* MySQL
* PDO
* Repository Pattern
* MVC Structure
* CRUD Operations
* Search
* Pagination
* Safe Sorting (Whitelist)
* Duplicate Validation

The project contains two modules:

### Module A - Students

* List students
* Search students
* Pagination
* Create student
* Edit student
* Delete student
* Duplicate email validation

### Module B - Payments

* List payments
* Search payments
* Create payment
* Edit payment
* Delete payment
* Duplicate payment code validation

---

## Project Structure

```text
public/
app/
├── Controllers/
├── Core/
├── Repositories/
├── Views/
│   ├── students/
│   ├── payments/
│   └── errors/
config/
database/
```

## Database

### Tables

1. students
2. payments

### Students Fields

* id
* student_code
* full_name
* email
* phone
* course
* status

### Payments Fields

* id
* payment_code
* student_email
* amount
* payment_status
* created_at

---

## Features Implemented

### T01 Environment Check

* PHP installed
* MySQL installed

### T02 Project Structure

* MVC folder structure
* Repository Pattern

### T03 Database Schema

* Primary Keys
* Unique Keys
* Indexes

### T04 Seed Data

* Sample data for students
* Sample data for payments

### T05 PDO Configuration

* utf8mb4
* ERRMODE_EXCEPTION
* FETCH_ASSOC
* EMULATE_PREPARES = false

### T06 Health Check

Endpoint:

```text
/health
```

Returns JSON status when database connection is successful.

### T07 Safe Repository Queries

All database operations use:

```php
prepare()
execute()
```

No raw SQL concatenation with user input.

### T08 Safe ORDER BY

Sorting uses whitelist validation.

Example:

```php
$allowedSorts = [
    'id',
    'student_code',
    'full_name',
    'email',
    'course',
    'status'
];
```

### T09 Student List

* Display students
* Search
* Pagination

### T10 Create Student

* Validation
* Flash Success Message

### T11 Duplicate Student

* Duplicate email detection

### T12 Edit Student

* Update existing records

### T13 Delete Student

* POST request only
* Confirmation dialog

### T14 Payment List

* Display payments
* Search

### T15 Create Payment

* Duplicate payment code detection

### T16 Pagination Validation

Handles:

```text
?page=-5
?page=9999
```

Safely.

### T17 Sort Injection Protection

Example tested:

```text
/students?sort=id DESC;DROP TABLE students
```

Application remains safe.

### T18 Safe Database Error

Database exceptions are hidden from end users.

Displayed message:

```text
Database connection error
```

instead of SQLSTATE or stack traces.

### T19 EXPLAIN Query

Verified index usage using:

```sql
EXPLAIN FORMAT=TRADITIONAL
SELECT *
FROM students
ORDER BY id DESC;
```

Result shows:

```text
key = PRIMARY
```

### T20 Git & GitHub

Project managed using Git and GitHub.

---

## Run Project

### Import Database

```sql
schema.sql
seed.sql
```

### Configure Database

Edit:

```text
config/database.php
```

### Start Application

```bash
php -S localhost:8000 -t public
```

### Open Browser

```text
http://localhost:8000
```

---

## Technologies

* PHP
* MySQL
* PDO
* HTML
* CSS
* Git
* GitHub