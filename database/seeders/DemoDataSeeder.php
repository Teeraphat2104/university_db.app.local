<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/demo_data.sql');

        if (!file_exists($path)) {
            $this->command->error('File demo_data.sql not found at: ' . $path);
            return;
        }

        // Disable foreign key checks to allow truncating tables with relations
        Schema::disableForeignKeyConstraints();

        // Truncate tables to ensure a clean slate before importing
        DB::table('activity_participants')->truncate();
        DB::table('activities')->truncate();
        DB::table('categories')->truncate();
        DB::table('admins')->truncate();

        // Read and execute the SQL file
        $sql = file_get_contents($path);
        DB::unprepared($sql);

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();

        $this->command->info('Demo data has been successfully imported!');
    }
}
