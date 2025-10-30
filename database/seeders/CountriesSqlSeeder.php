<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesSqlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlPath = database_path('sql/country_tables.sql');
        if (!file_exists($sqlPath)) {
            $this->command->info("country_tables.sql not found at $sqlPath, skipping CountriesSqlSeeder.");
            return;
        }

        $sql = file_get_contents($sqlPath);

        // Only import INSERTs for these tables to avoid running DDL from the dump
        $allowedTables = [
            'countries',
            'country_codes',
            'country_dialing_codes',
            'country_states',
        ];

        // Split statements by semicolon and run INSERTs that target allowed tables
        $statements = preg_split('/;\s*\n/', $sql);
        $count = 0;

        foreach ($statements as $stmt) {
            $trim = trim($stmt);
            if (stripos($trim, 'insert into') === 0) {
                // Extract table name
                if (preg_match('/INSERT INTO\s+`([^`]+)`/i', $trim, $m)) {
                    $table = $m[1];
                    if (in_array($table, $allowedTables, true)) {
                        try {
                            DB::statement($trim);
                            $count++;
                        } catch (\Exception $e) {
                            $this->command->error("Failed to insert into $table: " . $e->getMessage());
                        }
                    }
                }
            }
        }

        $this->command->info("CountriesSqlSeeder: executed $count INSERT statements.");
    }
}
