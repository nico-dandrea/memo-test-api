# MemoTest API

This repository contains a Laravel application that uses Docker and Docker Compose for deployment.

## Installation

1. Clone the repository.
2. Copy the `.env.example` file and create a new `.env` file:

   ```bash
   cp .env.example .env
   ```
3. Generate the application key: `./vendor/bin/sail artisan key:generate`
4. Run the appropriate installer script for your operating system, this will run a basic container with PHP8.3 to install all the composer dependencies without the need to have it installed locally.
   - Linux: `./installer.sh`
   - Windows: `./installer.bat`
   - If the installation scripts don't work, refer to the [Laravel Sail documentation](https://laravel.com/docs/10.x/sail#installing-composer-dependencies-for-existing-projects) for manual installation instructions.

## Laravel Sail

Laravel Sail is used to run the containers and working as a CLI for interacting with PHP `artisan` and also being able to `up` or `down` as with `docker-compose`.
To use Sail, you have to use the `bin` inside the `vendor` folder.

```bash
./vendor/bin/sail
```

Consider creating an alias for this command for convenience `alias sail="./vendor/bin/sail"`.
Now you can run `artisan` commands with Sail!

```bash
sail artisan list
sail artisan help
sail artisan make:model
```
Etc.

## Running Tests

You can run the tests with `sail artisan test`

## Database Migrations

To set up the database, run the migrations along with seeders:

```bash
./vendor/bin/sail artisan migrate --seed
```

Make sure to review the database configuration in the `.env` file before running the migrations.

## Front End APP
For the Front End refer to the following repository [MemoTestAPP](https://github.com/nico-dandrea/memo-test-app)
