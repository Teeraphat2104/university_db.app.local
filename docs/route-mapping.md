# Route Mapping

Current application structure uses one invokable action file per route for both Web and API layers.

## Response Rules

- Browser requests render normal HTML pages or redirect with flash messages.
- Requests that send `Accept: application/json` or hit `/api/*` return the shared JSON envelope.
- JSON response shape is standardized in `app/Support/ApiResponse.php`:
  - success: `{ status, message, data }`
  - error: `{ status, message, error }`
  - validation only: `{ status: 422, message, errors }`
- Shared JSON detection lives in `app/Support/JsonRequest.php`.
- Shared JSON exception rendering lives in `bootstrap/app.php`.
- Admin authorization uses the same JSON rule in `app/Http/Middleware/EnsureAdmin.php`.

## Web Routes

| Method | URI | Name | Middleware | Action File |
| --- | --- | --- | --- | --- |
| GET | `/` | `home` | `web` | `app/Actions/Web/Public/HomeAction.php` |
| GET | `/activities` | `activities.index` | `web` | `app/Actions/Web/Public/Activities/IndexAction.php` |
| GET | `/activities/{activity}` | `activities.show` | `web` | `app/Actions/Web/Public/Activities/ShowAction.php` |
| GET | `/search` | `activities.search` | `web` | `app/Actions/Web/Public/Activities/IndexAction.php` |
| GET | `/admin/login` | `admin.login` | `web, guest` | `app/Actions/Web/Admin/Auth/ShowLoginAction.php` |
| POST | `/admin/login` | `admin.login.store` | `web, guest` | `app/Actions/Web/Admin/Auth/LoginAction.php` |
| POST | `/admin/logout` | `admin.logout` | `web, auth, admin` | `app/Actions/Web/Admin/Auth/LogoutAction.php` |
| GET | `/admin/dashboard` | `admin.dashboard` | `web, auth, admin` | `app/Actions/Web/Admin/Dashboard/IndexAction.php` |
| GET | `/admin/activities` | `admin.activities.index` | `web, auth, admin` | `app/Actions/Web/Admin/Activities/IndexAction.php` |
| GET | `/admin/activities/create` | `admin.activities.create` | `web, auth, admin` | `app/Actions/Web/Admin/Activities/CreateAction.php` |
| POST | `/admin/activities` | `admin.activities.store` | `web, auth, admin` | `app/Actions/Web/Admin/Activities/StoreAction.php` |
| GET | `/admin/activities/{activity}` | `admin.activities.show` | `web, auth, admin` | `app/Actions/Web/Admin/Activities/ShowAction.php` |
| GET | `/admin/activities/{activity}/edit` | `admin.activities.edit` | `web, auth, admin` | `app/Actions/Web/Admin/Activities/EditAction.php` |
| PUT | `/admin/activities/{activity}` | `admin.activities.update` | `web, auth, admin` | `app/Actions/Web/Admin/Activities/UpdateAction.php` |
| DELETE | `/admin/activities/{activity}` | `admin.activities.destroy` | `web, auth, admin` | `app/Actions/Web/Admin/Activities/DeleteAction.php` |
| GET | `/admin/categories` | `admin.categories.index` | `web, auth, admin` | `app/Actions/Web/Admin/Categories/IndexAction.php` |
| GET | `/admin/categories/create` | `admin.categories.create` | `web, auth, admin` | `app/Actions/Web/Admin/Categories/CreateAction.php` |
| POST | `/admin/categories` | `admin.categories.store` | `web, auth, admin` | `app/Actions/Web/Admin/Categories/StoreAction.php` |
| GET | `/admin/categories/{category}/edit` | `admin.categories.edit` | `web, auth, admin` | `app/Actions/Web/Admin/Categories/EditAction.php` |
| PUT | `/admin/categories/{category}` | `admin.categories.update` | `web, auth, admin` | `app/Actions/Web/Admin/Categories/UpdateAction.php` |
| DELETE | `/admin/categories/{category}` | `admin.categories.destroy` | `web, auth, admin` | `app/Actions/Web/Admin/Categories/DeleteAction.php` |

## API Routes

Base prefix: `/api/v1`

| Method | URI | Name | Middleware | Action File |
| --- | --- | --- | --- | --- |
| POST | `/api/v1/auth/login` | `api.v1.auth.login` | `api` | `app/Actions/Api/V1/Auth/LoginAction.php` |
| POST | `/api/v1/auth/logout` | `api.v1.auth.logout` | `api, auth, admin` | `app/Actions/Api/V1/Auth/LogoutAction.php` |
| GET | `/api/v1/activities` | `api.v1.activities.index` | `api` | `app/Actions/Api/V1/Activities/IndexAction.php` |
| GET | `/api/v1/activities/{id}` | `api.v1.activities.show` | `api` | `app/Actions/Api/V1/Activities/ShowAction.php` |
| POST | `/api/v1/activities` | `api.v1.activities.store` | `api, auth, admin` | `app/Actions/Api/V1/Activities/StoreAction.php` |
| PUT | `/api/v1/activities/{id}` | `api.v1.activities.update` | `api, auth, admin` | `app/Actions/Api/V1/Activities/UpdateAction.php` |
| DELETE | `/api/v1/activities/{id}` | `api.v1.activities.destroy` | `api, auth, admin` | `app/Actions/Api/V1/Activities/DeleteAction.php` |
| GET | `/api/v1/categories` | `api.v1.categories.index` | `api` | `app/Actions/Api/V1/Categories/IndexAction.php` |
| POST | `/api/v1/categories` | `api.v1.categories.store` | `api, auth, admin` | `app/Actions/Api/V1/Categories/StoreAction.php` |
| PUT | `/api/v1/categories/{id}` | `api.v1.categories.update` | `api, auth, admin` | `app/Actions/Api/V1/Categories/UpdateAction.php` |
| DELETE | `/api/v1/categories/{id}` | `api.v1.categories.destroy` | `api, auth, admin` | `app/Actions/Api/V1/Categories/DeleteAction.php` |
| POST | `/api/v1/activities/{id}/documents` | `api.v1.documents.store` | `api, auth, admin` | `app/Actions/Api/V1/Activities/UploadDocumentAction.php` |
| DELETE | `/api/v1/documents/{id}` | `api.v1.documents.destroy` | `api, auth, admin` | `app/Actions/Api/V1/Documents/DeleteAction.php` |

## Shared Patterns

- Activity filtering is centralized in `app/Models/Activity.php` via `filterRules()` and `scopeApplyFilters()`.
- Public home search and `/activities` now use the same activity filtering rules.
- Activity PDF storage is centralized in `app/Support/ActivityDocumentStorage.php`.
- Admin category management is separate from activity management and feeds the category selector on activity create/edit pages.
