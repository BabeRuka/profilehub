# Laravel ProfileHub

A Laravel package to manage user profiles.

## Installation

```bash
composer require baberuka/profilehub
```

If the previous command doesn't work, try specifying the parameters more explicitly.

```bash
composer require "baberuka/profilehub:dev-main" --no-interaction --prefer-dist
```

## Register the Service Provider (if not auto-discovered)
If you're not using Laravel auto-discovery, register the provider manually in config/app.php.
Add the ProfileHubServiceProvider calls to the providers section. 

```
    'providers' => [
        BabeRuka\ProfileHub\ProfileHubServiceProvider::class,
    ],
```
## Publishing

```bash
php artisan vendor:publish --tag=profilehub-config
php artisan vendor:publish --tag=profilehub-views
php artisan vendor:publish --tag=profilehub-assets
php artisan vendor:publish --tag=profilehub-seeders

```
## Run the Migrations

```bash
php artisan migrate --path=vendor/baberuka/profilehub/database/migrations/2025_04_23_111700_create_pages_table.php --force
php artisan profilehub:migrate
php artisan migrate
```

## Run the seeders

```bash
php artisan db:seed --class="Database\\Seeders\\DatabaseSeeder" --force
```

## Usage

Visit `/profilehub/index` to check if it's working.
