<?php

namespace BabeRuka\ProfileHub\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MigrateProfilehubCommand extends Command
{
    protected $signature = 'profilehub:migrate';
    protected $description = 'Run the migrations specifically for the Profilehub package';

    public function handle()
    {
        $migrationPath = __DIR__ . '/../../../database/migrations';

        if (is_dir($migrationPath)) {
            $this->info('Running Profilehub migrations...');

            $migrator = $this->laravel->make('migrator');

            if (! $migrator->repositoryExists()) {
                $migrator->createRepository();
            }

            $files = $this->laravel['files']->glob($migrationPath . '/*.php');

            $ran = $migrator->run($files);

            if (! empty($ran)) {
                $this->info('Migrated: ' . implode(', ', $ran));
                $this->info('Profilehub migrations complete.');
            } else {
                $this->info('No Profilehub migrations to run.');
            }
        } else {
            $this->error("Profilehub migration directory not found at: $migrationPath");
        }
    }
}
