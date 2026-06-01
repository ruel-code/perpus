# Perpus — Library Management System

## Stack

- **Laravel 13** / PHP 8.3+, **MySQL 8.0** (database `perpustakaan`, user `root` no password via Laragon), **Sanctum** API tokens
- **Blade SPA** frontend: jQuery + DataTables + SweetAlert2 (loaded from CDN, **not** bundled)
- **Tailwind CSS v4** via CDN `<script>` in `app.blade.php` (Vite build mostly unused for CSS)
- Queue: `database` driver; Cache: `database` driver; Session: `file` driver

## Developer Commands

```bash
composer dev        # concurrent: serve + queue:listen + pail (logs) + Vite HMR (requires Node.js)
composer test       # config:clear + artisan test (SQLite :memory:, no .env needed)
composer setup      # fresh start: install deps, .env, key:gen, migrate, npm install/build
php artisan migrate --seed         # migrations + seeders (CategorySeeder must run first)
php artisan migrate:fresh --seed   # full DB reset + seed
php artisan db:seed                # seed in order: Category → User → Book → Loan → Fine
```

`composer test` uses `phpunit.xml` env defaults (sqlite :memory:, array cache, sync queue). No `.env` configuration needed — test env vars are set in `phpunit.xml:20-35`.

## Architecture

- **API-first** — all data flows through `routes/api.php`; Blade views fetch via AJAX
- **Auth** — Sanctum token in `localStorage`, sent as `Authorization: Bearer` (set globally in `app.blade.php:317`)
- **2 roles** (string field on `users.role`): `admin` (staff/officer), `user` (student/regular)
- **Role enforcement** via `RoleMiddleware` (aliased as `role:` in `bootstrap/app.php:16`) — accepts comma- or pipe-separated role lists
- **API response format** via `ApiResponse` trait: `{status: bool, message: string|null, data/errors: mixed}`
- **Loan statuses** (Indonesian): `dipinjam` (active), `dikembalikan` (returned), `terlambat` (overdue)
- **Fine payment statuses**: `unpaid`, `paid`
- **Fine rate**: `Fine::DAILY_FINE = 1000` (Rp 1,000/day late), calculated in `LoanController::update()` on return
- **Stock management** — `Book` has `stock` and `available_stock`; decremented on loan create, incremented on return
- **Auto-generated** — `Loan` codes: `LIB-YYYYMMDD-XXX`; `Category` slugs (unique with collision retry)
- **Model binding** — all controllers use implicit route model binding (`Book $book`, `Loan $loan`, etc.)
- **Validation** — dedicated Form Request classes per operation (`StoreBookRequest`, `UpdateLoanStatusRequest`, etc.)
- **Transactions** — `LoanController::store()` and `update()` wrap mutations in `DB::transaction`
- **`web.php` routes have no auth middleware** — auth is enforced client-side via the SPA

## Testing

- **PHPUnit 12** (not Pest) — run `composer test` or `vendor/bin/phpunit`
- Existing tests (`tests/Feature/ExampleTest.php`, `tests/Unit/ExampleTest.php`) are placeholders only
- DB-dependent tests should use `RefreshDatabase` (currently commented out in ExampleTest)
- No CI/CD pipelines, no pre-commit hooks

## Quirks & Gotchas

- `.npmrc` has `ignore-scripts=true` — `npm install` skips all lifecycle scripts
- `awesome-design-md/` is a vendored external collection of DESIGN.md files (inspiration), **not** part of the app
- Tailwind v4 in production views comes from CDN `tailwind.config` block in `app.blade.php:15`, **not** from the Vite build
- `laravel/pint` is available for formatting (`composer pint`) but no enforcement
- `CategorySeeder` must run before `BookSeeder` and `LoanSeeder` (foreign key dependency)
- Session driver is `file` (not `database` as `.env.example` suggests); cache and queue use `database`
- PHP 8.3+ required
