# Laravel Application

This repository contains a Laravel application that uses Docker and Docker Compose for deployment.

## Installation

1. Clone the repository.
2. Copy the `.env.example` file and create a new `.env` file:
   ```bash
   cp .env.example .env
   ```
3. Generate the application key: `./vendor/bin/sail artisan key:generate`
4. Run the appropriate installer script for your operating system:
   - Linux: `./installer.sh`
   - Windows: `./installer.bat`
   - If the installation scripts don't work, refer to the [Laravel Sail documentation](https://laravel.com/docs/10.x/sail#installing-composer-dependencies-for-existing-projects) for manual installation instructions.

## Running Commands

To run commands that would typically require `php artisan`, use the following command:

```bash
./vendor/bin/sail
```

Consider creating an alias for this command for convenience.

## Database Migrations

To set up the database, run the migrations along with seeders:

```bash
./vendor/bin/sail artisan migrate --seed
```

Make sure to review the database configuration in the `.env` file before running the migrations.

I added a Postman Collection If needed for testing the GraphQL endpoints

Have a nice day!