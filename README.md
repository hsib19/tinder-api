# Backend for Tinder Apps

## Overview

This is a Laravel 12 project skeleton configured with essential packages and ready for API development for a Tinder-like application.

### Key Features

* Laravel 12 Framework
* PHP 8.2+
* Sanctum for API authentication
* L5-Swagger for API documentation
* Queue workers with `queue:listen`
* Custom JSON response helper (`app/Helpers/JsonResponse.php`)

## Development

Run the development environment using Turborepo-style parallel commands:

```bash
npm run dev
```

This will start:

* Laravel server
* Queue listener
* Log viewer via Pail

## API Documentation

Swagger is configured via L5-Swagger. To generate or view API docs:

```bash
php artisan l5-swagger:generate
```

Access the docs at:

```
http://localhost:8000/api/documentation
```

## Project Structure

```
app/               # Application code
app/Helpers        # Custom helpers
app/Http           # Controllers, Middleware, Resources
api/routes/console.php  # Cronjobs and artisan command definitions
config/            # Laravel configuration files
database/          # Migrations, seeders, factories
public/            # Frontend assets
resources/         # Views and frontend resources
routes/            # API routes
tests/             # Unit and feature tests
```

## Documentation Links

* [API Cronjob Docs](./docs/API-CRON.md)
* [Database Schema Docs](./docs/DATABASE.md)

## Environment Variables

* `APP_NAME`, `APP_ENV`, `APP_KEY`, `APP_URL`
* `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
* `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_ENCRYPTION`, `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME`
* `ADMIN_EMAIL` (for cronjob notifications)

## Cronjobs

Defined in `api/routes/console.php`:

* Notify admin if a user is liked by more than 50 people

## Notes

* Use `MAIL_MAILER=log` in development to log emails instead of sending.
* Database migrations run automatically during setup.
* Adjust cronjob frequency via OS cron or queue scheduling as needed.
