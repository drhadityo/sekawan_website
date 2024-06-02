<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Info'
        ]);
        Category::create([
            'name' => 'Artikel'
        ]);
        Category::create([
            'name' => 'Kegiatan'
        ]);
    }
}
