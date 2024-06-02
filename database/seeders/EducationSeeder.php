<?php

namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Education::create([
            'education' => 'SD'
        ]);
        Education::create([
            'education' => 'SMP'
        ]);
        Education::create([
            'education' => 'SMA'
        ]);
        Education::create([
            'education' => 'Sarjana'
        ]);
        Education::create([
            'education' => 'Lainnya'
        ]);
    }
}
