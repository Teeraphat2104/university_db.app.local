<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'กิจกรรมวิชาการ',      'status' => true],
            ['name' => 'กีฬาและนันทนาการ',     'status' => true],
            ['name' => 'บำเพ็ญประโยชน์',       'status' => true],
            ['name' => 'ศิลปวัฒนธรรม',         'status' => true],
            ['name' => 'พัฒนาทักษะวิชาชีพ',    'status' => true],
            ['name' => 'กิจกรรมนักศึกษา',      'status' => true],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}
