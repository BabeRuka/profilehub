<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the pages SQL importer seeder which will import INSERT statements
        $this->call([
            PagesSqlSeeder::class,
            CountriesSqlSeeder::class,
        ]);
    }
}
