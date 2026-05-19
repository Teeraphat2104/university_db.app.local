# University Activity Management System
## Website Development Process (Laravel + Blade)

---

# 1. Project Overview

## Project Name

University Activity Management System

---

## Project Objective

ระบบสำหรับจัดการกิจกรรมมหาวิทยาลัยและเก็บรายชื่อนักศึกษาที่เข้าร่วมกิจกรรมต่าง ๆ

---

## Main Features

- Authentication
- Activity Management
- Student Management
- Participant Management
- Excel Import / Export
- Reports Dashboard

---

# 2. Technology Stack

## Frontend

- Laravel Blade
- Bootstrap / Tailwind CSS
- JavaScript
- jQuery / AJAX

---

## Backend

- Laravel

---

## Database

- MySQL

---

## Additional Packages

### Laravel Excel

```bash
composer require maatwebsite/excel
```

### Laravel Breeze

```bash
composer require laravel/breeze --dev
```

### Spatie Permission

```bash
composer require spatie/laravel-permission
```

---

# 3. System Users

## Admin

- จัดการระบบทั้งหมด
- จัดการผู้ใช้
- จัดการกิจกรรม
- ดูรายงาน

---

## Staff

- เพิ่มกิจกรรม
- อัปโหลดรายชื่อนักศึกษา
- ดูผู้เข้าร่วม

---

## Student

- ดูประวัติการเข้าร่วมกิจกรรม
- ดาวน์โหลดเกียรติบัตร

---

# 4. Development Process

---

# Phase 1: Requirement Gathering

## Functional Requirements

### Authentication

- Login
- Logout
- Forgot Password

---

### Activity Management

- Create Activity
- Edit Activity
- Delete Activity
- Search Activity

---

### Participant Management

- Add Participant
- Import Excel
- Export Excel
- Check Attendance

---

### Reports

- Activity Reports
- Student Reports
- Faculty Reports

---

## Non-Functional Requirements

- Responsive Design
- Secure Authentication
- Fast Performance
- File Validation

---

# Phase 2: Project Setup

---

## Create Laravel Project

```bash
composer create-project laravel/laravel university-activity
```

---

## Install Breeze

```bash
composer require laravel/breeze --dev

php artisan breeze:install blade

npm install
npm run dev

php artisan migrate
```

---

## Configure Database

### .env

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=university_activity
DB_USERNAME=root
DB_PASSWORD=
```

---

# Phase 3: Database Design

---

# Tables Structure

---

## users

| Column | Type |
|---|---|
| id | bigint |
| name | string |
| email | string |
| password | string |
| role | string |

---

## students

| Column | Type |
|---|---|
| id | bigint |
| student_id | string |
| name | string |
| faculty | string |
| major | string |
| year | integer |

---

## activities

| Column | Type |
|---|---|
| id | bigint |
| title | string |
| description | text |
| date | date |
| location | string |
| category | string |

---

## participants

| Column | Type |
|---|---|
| id | bigint |
| activity_id | foreignId |
| student_id | foreignId |
| status | string |
| checked_in_at | datetime |

---

# Relationships

## Activity Model

```php
public function participants()
{
    return $this->hasMany(Participant::class);
}
```

---

## Student Model

```php
public function participants()
{
    return $this->hasMany(Participant::class);
}
```

---

## Participant Model

```php
public function activity()
{
    return $this->belongsTo(Activity::class);
}

public function student()
{
    return $this->belongsTo(Student::class);
}
```

---

# Phase 4: Laravel MVC Structure

---

# Project Structure

```txt
app/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
│
├── Models/
│
resources/
├── views/
│   ├── layouts/
│   ├── dashboard/
│   ├── activities/
│   ├── students/
│   ├── participants/
│   └── reports/
```

---

# Phase 5: Authentication System

---

# Install Authentication

```bash
php artisan breeze:install blade
```

---

# Authentication Features

- Login
- Register
- Forgot Password
- Middleware Protection

---

# Middleware Example

```php
Route::middleware(['auth'])->group(function () {

});
```

---

# Phase 6: Route Development

---

# web.php

```php
Route::middleware(['auth'])->group(function () {

    Route::resource('activities', ActivityController::class);

    Route::resource('students', StudentController::class);

    Route::resource('participants', ParticipantController::class);

});
```

---

# Phase 7: Controller Development

---

# Generate Controllers

```bash
php artisan make:controller ActivityController --resource

php artisan make:controller StudentController --resource

php artisan make:controller ParticipantController --resource
```

---

# CRUD Methods

```txt
index()
create()
store()
show()
edit()
update()
destroy()
```

---

# Example Store Method

```php
public function store(Request $request)
{
    Activity::create([
        'title' => $request->title,
        'description' => $request->description,
        'date' => $request->date,
    ]);

    return redirect()->route('activities.index');
}
```

---

# Phase 8: Blade UI Development

---

# Main Layout

## resources/views/layouts/app.blade.php

```blade
<body>

    @include('layouts.sidebar')

    <main>
        @yield('content')
    </main>

</body>
```

---

# Sidebar Structure

```txt
Dashboard
Activities
Students
Participants
Reports
Settings
Logout
```

---

# Activities Page Structure

```txt
Search Bar
Create Button
Activity Table
Pagination
```

---

# Example Table

```blade
<table class="table">

    <thead>
        <tr>
            <th>Title</th>
            <th>Date</th>
            <th>Participants</th>
        </tr>
    </thead>

</table>
```

---

# Phase 9: Dashboard Development

---

# Dashboard Cards

```txt
Total Activities
Total Students
Total Participants
Today's Activities
```

---

# Dashboard Charts

ใช้:

- Chart.js
- ApexCharts

---

# Dashboard Layout

```txt
Sidebar
 ├── Dashboard
 ├── Activities
 ├── Students
 ├── Reports
 └── Settings
```

---

# Phase 10: Excel Import System

---

# Import Flow

```txt
Upload File
 → Validate Data
 → Preview Data
 → Save Database
```

---

# Upload Form

```blade
<form action="{{ route('participants.import') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    <input type="file" name="file">

    <button type="submit">
        Upload
    </button>

</form>
```

---

# Generate Import Class

```bash
php artisan make:import ParticipantsImport --model=Participant
```

---

# Phase 11: Search & Filter

---

# Features

- Search Activity
- Filter Faculty
- Filter Date
- AJAX Search
- Pagination

---

# AJAX Flow

```txt
Search Input
 → AJAX Request
 → Controller
 → Return Blade Partial
```

---

# Phase 12: Reports System

---

# Report Types

- Activity Reports
- Student Reports
- Faculty Reports
- Year Reports

---

# Export Features

- Export Excel
- Export PDF
- Print Report

---

# Phase 13: Security

---

# Security Features

- Authentication
- Authorization
- CSRF Protection
- File Validation
- Middleware

---

# Role Middleware

```php
Route::middleware(['role:admin'])->group(function () {

});
```

---

# Phase 14: Responsive Design

---

# Responsive Layout

```txt
Desktop → Sidebar
Tablet → Collapse Sidebar
Mobile → Drawer Menu
```

---

# Recommended UI Design

## Style

- Minimal
- Clean Dashboard
- University Theme
- Rounded Cards
- Soft Shadow

---

## Color Palette

```txt
Primary   : #2563EB
Success   : #16A34A
Danger    : #DC2626
Background: #F8FAFC
```

---

# Phase 15: Testing

---

# Frontend Testing

- Responsive Testing
- Form Validation
- UI Testing

---

# Backend Testing

- CRUD Testing
- Authentication Testing
- Import Testing

---

# Security Testing

- SQL Injection
- XSS
- CSRF
- File Upload Validation

---

# Phase 16: Deployment

---

# Shared Hosting Commands

```bash
php artisan optimize

php artisan storage:link
```

---

# Deployment Options

- Shared Hosting
- VPS
- Docker
- Nginx
- Apache

---

# Recommended Deployment Stack

```txt
Laravel
↓
Apache / Nginx
↓
MySQL
```

---

# Phase 17: Future Improvements

---

# Advanced Features

- QR Check-in
- Certificate Generator
- Student Activity Hours
- Email Notifications
- Mobile Application

---

# Final Recommended Structure

```txt
resources/views/
├── layouts/
├── dashboard/
├── activities/
├── students/
├── participants/
├── reports/
└── auth/
```

---

# Recommended Development Order

```txt
1. Authentication
2. Database Design
3. Activities CRUD
4. Students CRUD
5. Participants Management
6. Dashboard
7. Reports
8. Excel Import
9. Search & Filter
10. Deployment
```