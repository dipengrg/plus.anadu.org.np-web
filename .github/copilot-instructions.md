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
# Copilot Instructions — Plus Anadu (concise)

Purpose: quick, actionable guidance for AI coding agents working on this Laravel API focused on phone+OTP authentication.

Big picture
- API-only Laravel 12 backend (Sanctum) with minimal Vite/Tailwind assets. Auth is phone-centric OTPs stored on `users`.
- Key files: [app/Http/Controllers/API/OtpController.php](app/Http/Controllers/API/OtpController.php), [routes/api.php](routes/api.php), [app/Models/User.php](app/Models/User.php), migration [database/migrations/2025_12_10_102311_update_users_table.php](database/migrations/2025_12_10_102311_update_users_table.php).

Critical flows & conventions
- OTP flow: `POST /api/otp/request` → save `otp` + `otp_created_at` on user; `POST /api/otp/verify` → exact-match check + 3-minute expiry → clear OTP and issue token via `$user->createToken('mobile')->plainTextToken`.
- Always return JSON with a `message` key. Use explicit HTTP codes: 200, 422 (validation), 404, 410 (OTP expired).
- Validation lives in controllers via `$request->validate(...)`. Do not move to models.

Useful snippets
- OTP expiry check (use Carbon):
```php
if ($user->otp_created_at && Carbon::parse($user->otp_created_at)->addMinutes(3)->isPast()) {
    return response()->json(['message' => 'OTP expired'], 410);
}
```
- Token creation:
```php
$token = $user->createToken('mobile')->plainTextToken;
```

Developer workflows
- Setup: `composer install && npm install && php artisan key:generate && php artisan migrate && npm run build`.
- Dev (one-liner): `composer run dev` (runs `serve`, queue listener, pail logs, and `npm run dev`).
- Tests: `./vendor/bin/pest` (or filter by file/label). Tests use in-memory SQLite as configured in `phpunit.xml`.
- Formatting: `./vendor/bin/pint`.

Integration points & TODOs
- SMS: `OtpController::requestOtp()` stores OTP but does not send SMS. Look for the `TODO` and add an SMS service (e.g., `app/Services/SmsService.php`) or dispatch a queued job. Example dispatch: `SendOtpSms::dispatch($user->phone, $otp)`.
- Queue: `config/queue.php` is present but sending is synchronous today — move SMS sending to a queued job for production.

Where to extend
- Add API controllers under `app/Http/Controllers/API/`, add routes in `routes/api.php`, validate with `$request->validate()`, return `['message'=>..., ...]` and add tests in `tests/Feature/`.

Notes for agents
- Preserve existing API response shapes and status codes. Follow the OTP expiry pattern above. Use `'mobile'` as the Sanctum token name.
- Sensitive fields: `otp` and `otp_created_at` are hidden on the `User` model — don't expose them in responses.

If anything here is unclear or you'd like more detail (sms provider examples, job scaffolding, or tests added), tell me which area to expand.
./vendor/bin/pest --filter=testName  # Specific test
