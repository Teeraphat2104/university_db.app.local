# AI Agent Customization Guide — University Activity Management System

**Project:** University Activity Management System  
**Stack:** Laravel 12 | MySQL | Blade | Vite + Tailwind CSS  
**Architecture:** REST API (Sanctum auth) + Server-Rendered Blade Templates

---

## Project Overview

A web application for managing university activities, participants, and administrative functions. The system serves **Admins** (manage everything) and **Students** (view activities and history).

**Key features:** Activity CRUD, participant management, Excel import/export, role-based access control, file storage, activity reports.

See [dev.md](dev.md) for detailed feature documentation.

---

## Essential Commands

### Development (Concurrent server, queue, logs, Vite)
```bash
composer run dev
```
Runs: Laravel server, queue listener, Pail logs, Vite dev server.

### Backend Setup (First Time)
```bash
php artisan migrate --force
php artisan db:seed
```

### Build for Production
```bash
npm run build
```

### Testing
```bash
php artisan test
php artisan test --filter=TestName
```

### Artisan Shortcuts
```bash
php artisan tinker              # Interactive shell
php artisan make:model Activity # Generate models
php artisan make:migration      # Create migration
php artisan db:seed             # Run seeders
```

**Docker alternative:** `docker compose exec app php artisan [command]`

---

## Architecture & File Organization

### Request Flow

```
Route → Controller → Model → Database
                  ↓
            ApiResponse helper (JSON)
```

- **API Routes** ([routes/api.php](routes/api.php)): Sanctum-protected admin endpoints + public endpoints
- **Web Routes** ([routes/web.php](routes/web.php)): Blade view routes (simple pass-through)
- **Controllers** ([app/Http/Controllers](app/Http/Controllers)): REST logic, no business logic
- **Models** ([app/Models](app/Models)): Eloquent models with relationships, accessors for file URLs

### Key Models & Relationships

| Model | Purpose | Key Relations |
|-------|---------|----------------|
| `User` | Public students (registration planned) | — |
| `Admin` | System administrators | — |
| `Category` | Activity categories (e.g., Sports, Arts) | `hasMany(Activity)` |
| `Activity` | Events with metadata | `belongsTo(Category)`, `hasMany(ActivityParticipant)` |
| `ActivityParticipant` | Participants per activity | `belongsTo(Activity)` |

**Note:** Timestamps are **disabled** on all models (`public $timestamps = false;`). Use explicit `created_at`/`updated_at` columns in migrations only if needed.

### File Storage

Files (images, PDFs, Excel) are stored in `storage/app/public/` with URLs generated via accessors:

```php
$activity->cover_image_url   // Storage::disk('public')->url(...)
$activity->pdf_url
$activity->excel_url
```

---

## API Patterns & Response Format

### Standard Response Format (ApiResponse Helper)

All JSON responses use `app/Helpers/ApiResponse.php`:

```php
// Success
ApiResponse::success('Activity created', $activity, 201);
// → { "success": true, "message": "...", "data": {...} }

// Error
ApiResponse::error('Validation failed', $errors, 422);
// → { "success": false, "message": "...", "errors": {...} }

// Paginated
ApiResponse::paginated('Activities', $activities->paginate());
// → { "success": true, "data": [...], "meta": { "current_page": 1, "total": 50, ... } }
```

**Always use ApiResponse for consistency.** Do not return `response()->json()` directly.

### Authentication & Authorization

- **Admin login:** `POST /api/admin/login` (returns Sanctum token in `data.token`)
- **Token middleware:** `auth:sanctum` guards all admin routes
- **Role check:** `admin` custom middleware verifies `Admin` model (not `User`)
- **Public endpoints:** No auth required (e.g., `GET /api/public/activities`)

---

## Development Conventions

### Controllers

- **Responsibility:** Route handling, validation, database queries
- **Pattern:** Inject models/services in constructor, return `ApiResponse`
- **Validation:** Use `FormRequest` classes in `app/Http/Requests/` (auto-validated via type-hint)

Example:
```php
public function store(StoreActivityRequest $request, Activity $activity)
{
    $activity = Activity::create($request->validated());
    return ApiResponse::success('Created', $activity, 201);
}
```

### Models

- **Relationships:** Always use typed properties & return types (Laravel 12)
- **Accessors/Mutators:** Use property promotion (`#[Attribute]`)
- **File URLs:** Use `Attribute` accessor (not `getAttribute`)
- **Casts:** Always use `protected function casts()` (not `$casts`)

### Database

- **Migrations:** Store in `database/migrations/`, use timestamps for ordering
- **Seeders:** Use factories (`database/factories/`) + seed classes
- **Fixtures:** Demo data in `database/seeders/demo_data_inserts.sql`

### Frontend (Blade Templates)

- **Location:** `resources/views/` (organized by feature, e.g., `admin/`, `public/`)
- **Styling:** Tailwind CSS (configured in `vite.config.js`)
- **JavaScript:** Alpine.js or vanilla JS in `resources/js/`
- **API calls:** Axios from `resources/js/api.js`

---

## Environment & Configuration

### Key .env Variables

```env
APP_ENV=local              # or testing, production
DB_CONNECTION=mysql
DB_HOST=localhost          # or mysql (if Docker)
DB_DATABASE=uudb
DB_USERNAME=root
DB_PASSWORD=root

SANCTUM_STATEFUL_DOMAINS=localhost:3000,api.example.com
```

### Docker Setup

```bash
docker compose up -d       # Start all services
docker compose down        # Stop all services
docker compose logs -f     # Follow logs
```

Services:
- `app` → Laravel on port 8000
- `mysql` → Port 3306
- `phpmyadmin` → Port 8080

---

## Testing

- **Test framework:** PHPUnit
- **Structure:** `tests/Unit/`, `tests/Feature/`
- **Database:** SQLite in-memory (`:memory:` in `phpunit.xml`)
- **Factories:** Use `app/Models/Activity::factory()` to generate test data

Run tests:
```bash
php artisan test                      # All tests
php artisan test tests/Feature/       # Feature tests only
php artisan test --filter=ActivityTest
```

---

## Common Patterns for AI Agents

### ✅ DO

- Use ApiResponse helper for all API responses
- Type-hint route parameters (e.g., `Activity $activity` auto-resolves)
- Use form requests for validation (`StoreActivityRequest`)
- Leverage relationships (`$activity->participants`)
- Use factories in seeders and tests

### ❌ DON'T

- Return raw `response()->json()` (use ApiResponse)
- Mix business logic into controllers (delegate to models/services)
- Use `$timestamps = true` (disabled by convention)
- Query users/roles before verifying Admin model
- Store files outside `storage/app/public/`

---

## Useful Files to Reference

| File | Purpose |
|------|---------|
| [routes/api.php](routes/api.php) | API endpoint structure & auth guards |
| [app/Helpers/ApiResponse.php](app/Helpers/ApiResponse.php) | Response format spec |
| [app/Models/Activity.php](app/Models/Activity.php) | Model pattern example |
| [database/migrations/](database/migrations/) | DB schema reference |
| [database/factories/](database/factories/) | Test data generation |
| [phpunit.xml](phpunit.xml) | Test configuration |

---

## Tips for Efficient Development

1. **Prototype in Tinker:** `php artisan tinker` → experiment with models/relationships before writing code
2. **Watch migrations:** Run `php artisan migrate:status` to track applied migrations
3. **Seed fresh:** `php artisan migrate:fresh --seed` (destructive, for dev only)
4. **Test isolated:** Use `--filter` flag to run single test classes
5. **Check routes:** `php artisan route:list` to see all registered endpoints
