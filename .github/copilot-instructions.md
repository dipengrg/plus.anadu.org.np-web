# Copilot Instructions for Plus Anadu Codebase

## Project Overview
**Plus Anadu** is a Laravel 12 API-driven application focused on OTP-based authentication. The project uses:
- **Backend**: Laravel 12 with Sanctum for API token authentication
- **Frontend Build**: Vite + Tailwind CSS (assets only, minimal web views)
- **Database**: SQLite (default) or MySQL, migrated to phone-based OTP authentication
- **Testing**: Pest (next-generation testing framework for Laravel)
- **Queue System**: Integrated but not actively configured for SMS delivery

## Architecture & Data Flow

### Authentication Flow (Critical)
The app uses **phone-based OTP authentication** instead of traditional email/password:
1. User requests OTP via `POST /api/otp/request` with phone number
2. System generates 4-digit OTP, stores in `users.otp`, records `otp_created_at`
3. User verifies OTP via `POST /api/otp/verify` with phone + OTP
4. System validates OTP (exact match) and expiration (3-minute window per `OtpController`)
5. On success: OTP is cleared, Laravel Sanctum token is issued via `createToken('mobile')`
6. Token-based requests authenticated via `auth:sanctum` middleware

**Key Files**: `app/Http/Controllers/API/OtpController.php`, `routes/api.php`, `app/Models/User.php`

### User Model Schema
Phone-centric design (email removed):
- `id`, `role` (default: 'general'), `name`, `photo`, `dob`, `phone` (unique)
- `otp`, `otp_created_at`, `status` (boolean)
- Hidden attributes: `otp`, `otp_created_at` (never exposed in API responses)
- Timestamps auto-cast; `dob` and `otp_created_at` use datetime casting

**Migration History**: 
- Base migration creates default columns; update migration (2025_12_10_102311) removes email/password and restructures for phone + OTP
- Always reference the update migration for current schema

## Project-Specific Patterns

### API Response Convention
- Always return JSON with `message` field: `response()->json(['message' => '...'])`
- Include relevant data: `response()->json(['message' => '...', 'token' => $token, 'user' => $user])`
- Use HTTP status codes: 404 (not found), 422 (unprocessable), 410 (gone/expired), 200 (success)

### Validation Pattern
- Use `$request->validate(['field' => 'rules'])` in controllers
- Current OTP validation: phone (required|string), otp (required|numeric)
- Keep validation in controllers, not in models

### OTP Expiry Check
```php
// Explicit 3-minute window check
if ($user->otp_created_at && Carbon::parse($user->otp_created_at)->addMinutes(3)->isPast()) {
    return response()->json(['message' => 'OTP expired'], 410);
}
```
Always use this pattern when validating OTP timestamps. Don't use mutators; keep logic explicit in controllers.

### Token Creation
```php
$token = $user->createToken('mobile')->plainTextToken;
```
Always use `'mobile'` as the token name for API tokens (consistency with Sanctum setup).

## Development Workflows

### Environment Setup
```bash
composer install
npm install
php artisan key:generate
php artisan migrate
npm run build  # Tailwind/Vite compilation
```

### Development Server (All-in-One)
```bash
composer run dev
```
This runs concurrently:
- `php artisan serve` (port 8000)
- `php artisan queue:listen --tries=1` (queue worker)
- `php artisan pail --timeout=0` (real-time logs)
- `npm run dev` (Vite watch)

Use this for local development; manually kill if stuck.

### Testing
```bash
./vendor/bin/pest                 # All tests
./vendor/bin/pest tests/Feature   # Feature tests only
./vendor/bin/pest --filter=testName  # Specific test
```
Tests run against in-memory SQLite (configured in `phpunit.xml`). Tests inherit from `Tests\TestCase` which extends Laravel's base TestCase with access to HTTP testing traits.

### Database
```bash
php artisan migrate              # Run migrations
php artisan migrate:rollback     # Undo last batch
php artisan migrate:fresh        # Reset + re-seed
```
Default connection is SQLite (`database_path('database.sqlite')`); MySQL config available in `config/database.php`.

### Code Style
```bash
./vendor/bin/pint              # Format code (Laravel Pint)
./vendor/bin/pint --test       # Check without fixing
```

## Critical TODOs & Integration Points

### SMS Gateway Integration
The `OtpController::requestOtp()` method has a TODO comment (line ~32):
```php
// TODO: Integrate your SMS gateway here
// sendSms($user->phone, "Your OTP is: $otp");
```
**Action**: Implement SMS delivery before production. Currently OTP is stored but not sent. Common solutions:
- Twilio, AWS SNS, local SMS provider APIs
- Create a `Services\SmsService` class
- Inject via constructor or `app()` helper

### Queue Integration
Queue connection is configured (`config/queue.php`) but unused. OTP requests run synchronously. For production scalability, queue SMS sending:
```php
SendOtpSms::dispatch($user->phone, $otp);
```

### Sanctum Token Security
- Tokens are plain-text on first issue (`plainTextToken`)
- Client must store securely; subsequent requests send via `Authorization: Bearer {token}`
- No explicit token expiration set (uses Laravel's default)

## Common Tasks

### Adding a New API Endpoint
1. Create/extend controller in `app/Http/Controllers/API/{Feature}Controller.php`
2. Add route in `routes/api.php`
3. Validate input with `$request->validate([])`
4. Return JSON response with `message` + data
5. Add test in `tests/Feature/{Feature}Test.php`

### Modifying User Schema
1. Create migration: `php artisan make:migration add_field_to_users_table`
2. Define schema changes in `up()`/`down()`
3. Run: `php artisan migrate`
4. Update `User::$fillable` or `$hidden` if needed

### Testing API Endpoints
Use Pest feature tests with Sanctum tokens:
```php
use Tests\TestCase;

test('otp verification returns token', function () {
    $user = User::factory()->create(['otp' => '1234', 'otp_created_at' => now()]);
    $response = $this->postJson('/api/otp/verify', [
        'phone' => $user->phone,
        'otp' => '1234',
    ]);
    $response->assertOk()->assertHasPath('token');
});
```

## External Dependencies & Versions
- **Laravel**: 12.0 (latest stable)
- **PHP**: 8.2+
- **Sanctum**: 4.0 (API token auth)
- **Pest**: 4.1 + pest-plugin-laravel 4.0
- **Vite**: 7.0 + laravel-vite-plugin 2.0
- **Tailwind**: 4.0 (via @tailwindcss/vite)

Avoid outdated version assumptions; always check `composer.json` for actual versions.

## Conventions & Anti-Patterns
- **DO**: Return explicit HTTP status codes (410 for expired, 422 for validation)
- **DO**: Use `Carbon` for date comparisons (already imported in `OtpController`)
- **DO**: Hide sensitive fields via `Model::$hidden`
- **DON'T**: Use email/password fields (removed by design)
- **DON'T**: Manually hash OTP (store as plain integer for SMS delivery)
- **DON'T**: Set token expiration in Sanctum without explicit configuration
