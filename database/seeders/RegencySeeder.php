<?php

namespace Database\Seeders;

use App\Models\Regency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Kabupaten Jember
        Regency::create([
            'id' => '3509',
            'name' => 'KABUPATEN JEMBER',
        ]);

        // Kabupaten Lumajang
        // Regency::create([
        //     'id' => '3508',
        //     'name' => 'KABUPATEN LUMAJANG',
        // ]);

        // Kabupaten Bondowoso
        // Regency::create([
        //     'id' => '3511',
        //     'name' => 'KABUPATEN BONDOWOSO',
        // ]);
        
        // Kabupaten Situbondo
        // Regency::create([
        //     'id' => '3512',
        //     'name' => 'KABUPATEN SITUBONDO',
        // ]);
    }
}
