<?php

namespace Database\Seeders;

use App\Models\PatientStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PatientStatus::create([
            'status' => 'Sembuh'
        ]);
        PatientStatus::create([
            'status' => 'Berobat'
        ]);
        PatientStatus::create([
            'status' => 'Mangkir'
        ]);
        PatientStatus::create([
            'status' => 'Loss to follow up'
        ]);
        PatientStatus::create([
            'status' => 'Meninggal'
        ]);
    }
}
