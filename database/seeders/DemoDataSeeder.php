<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan migrate:fresh --seed
     */
    public function run(): void
    {
        $sqlPath = database_path('seeders/demo_data_inserts.sql');
        
        if (File::exists($sqlPath)) {
            DB::unprepared(File::get($sqlPath));
            $this->command->info('Demo data seeded successfully from demo_data_inserts.sql!');
        } else {
            $this->command->error('SQL file demo_data_inserts.sql not found!');
        }
    }
}
