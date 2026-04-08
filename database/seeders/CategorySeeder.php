<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Category::create(['name' => 'ผ่อนผัน']);
        \App\Models\Category::create(['name' => 'ทุนการศึกษา']);
        \App\Models\Category::create(['name' => 'เอกสารทั่วไป']);
    }
}
