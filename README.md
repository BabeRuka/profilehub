# Laravel ProfileHub

A Laravel package to manage user profiles.

## Installation

```bash
composer require baberuka/profilehub
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

```
## Run the Migrations

```bash
php artisan profilehub:migrate
php artisan migrate
```
## Usage

Visit `/profilehub/index` to check if it's working.
