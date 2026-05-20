# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

University Activity Management System - A Laravel 12 web application for managing university activities, participants, and administrative functions. Serves **Admins** (full system management) and **Students** (view activities and history).

## Development Commands

```bash
# Run development server (concurrent: Laravel, queue, logs, Vite)
composer run dev

# Backend setup (first time)
php artisan migrate --force
php artisan db:seed

# Build for production
npm run build

# Testing
php artisan test
php artisan test --filter=TestName

# Artisan shortcuts
php artisan tinker              # Interactive shell
php artisan make:model Activity # Generate model
php artisan make:migration     # Create migration
php artisan db:seed            # Run seeders
php artisan migrate:fresh --seed  # Fresh database
php artisan route:list         # List all routes
```

## Architecture

- **Stack:** Laravel 12 | MySQL | Blade | Vite + Tailwind CSS
- **Authentication:** Laravel Sanctum (API token-based)
- **Request Flow:** Route → Controller → Model → Database → ApiResponse helper

### Key Files

- **API Routes:** `routes/api.php` - Sanctum-protected admin endpoints + public endpoints
- **Web Routes:** `routes/web.php` - Blade view routes
- **Controllers:** `app/Http/Controllers/` - ActivityController, AdminAuthController, CategoryController, PublicController
- **Models:** `app/Models/` - Activity, Admin, Category, ActivityParticipant
- **Helpers:** `app/Helpers/ApiResponse.php` - Standardized JSON responses

### Models & Relationships

| Model | Purpose | Key Relations |
|-------|---------|---------------|
| `User` | Public students | - |
| `Admin` | System administrators | - |
| `Category` | Activity categories | `hasMany(Activity)` |
| `Activity` | Events with metadata | `belongsTo(Category)`, `hasMany(ActivityParticipant)` |
| `ActivityParticipant` | Participants per activity | `belongsTo(Activity)` |

**Note:** Timestamps disabled on all models (`public $timestamps = false;`)

### Features

- Activity CRUD with cover images, PDF, Excel attachments
- Participant management with check-in tracking
- Excel import/export (maatwebsite/excel)
- Role-based access control (spatie/laravel-permission)
- Category management
- Public activity browsing

### Docker Services

- `app`: Laravel on port 8000
- `nginx`: Port 8000
- `mysql`: Port 3306 (database: uudb, password: root)
- `phpmyadmin`: Port 8080

## API Patterns

### Response Format (via ApiResponse helper)

```php
// Success
ApiResponse::success('Activity created', $activity, 201);
// → { "success": true, "message": "...", "data": {...} }

// Error
ApiResponse::error('Validation failed', $errors, 422);
// → { "success": false, "message": "...", "errors": {...} }

// Paginated
ApiResponse::paginated('Activities', $activities->paginate());
```

### Authentication

- Admin login: `POST /api/admin/login` (returns Sanctum token in `data.token`)
- Token middleware: `auth:sanctum` guards all admin routes
- Public endpoints: No auth required (e.g., `GET /api/public/activities`)

## Development Conventions

### DO

- Use `ApiResponse` helper for all API responses
- Type-hint route parameters (e.g., `Activity $activity`)
- Use FormRequest classes for validation
- Store files in `storage/app/public/`

### DON'T

- Return raw `response()->json()` (use ApiResponse)
- Use `$timestamps = true`
- Store files outside `storage/app/public/`

## Testing

- Test framework: PHPUnit
- Database: SQLite in-memory (`:memory:` in `phpunit.xml`)
- Run: `php artisan test`