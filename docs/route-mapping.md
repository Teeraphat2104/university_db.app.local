# Route Mapping

Current application structure uses one invokable action file per route for both Web and API layers.

## Web Routes

| Method | URI | Name | Middleware | Action File |
| --- | --- | --- | --- | --- |
| GET | `/` | `home` | `web` | `app/Actions/Web/Public/HomeAction.php` |
| GET | `/activities` | `activities.index` | `web` | `app/Actions/Web/Public/Activities/IndexAction.php` |
| GET | `/activities/{activity}` | `activities.show` | `web` | `app/Actions/Web/Public/Activities/ShowAction.php` |
| GET | `/search` | `activities.search` | `web` | `app/Actions/Web/Public/Activities/SearchAction.php` |
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

## Notes

- Shared API JSON response format lives in `app/Support/ApiResponse.php`.
- Web and API route registration live in `routes/web.php` and `routes/api.php`.
- Admin access control still uses `app/Http/Middleware/EnsureAdmin.php`.
