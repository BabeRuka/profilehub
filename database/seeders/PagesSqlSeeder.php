<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesSqlSeeder extends Seeder
{
    /**
     * Read the bundled pages.sql and execute INSERT statements only.
     */
    public function run(): void
    {
        $path = database_path('sql/pages.sql');
        if (!file_exists($path)) {
            return;
        }

        $sql = file_get_contents($path);
        if (!$sql) {
            return;
        }

        // Extract INSERT statements and execute them. This avoids running DROP/CREATE statements.
        preg_match_all('/INSERT INTO `[^`]+` VALUES \([\s\S]*?\);/mi', $sql, $matches);
        if (isset($matches[0]) && count($matches[0]) > 0) {
            foreach ($matches[0] as $insert) {
                try {
                    DB::statement($insert);
                } catch (\Throwable $e) {
                    // skip problematic inserts but continue seeding
                    continue;
                }
            }
        }
    }
}
