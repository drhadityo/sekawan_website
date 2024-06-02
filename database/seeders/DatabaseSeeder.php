<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    private $article = 1;
    private $patient = 1;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ReligionSeeder::class,
            CategorySeeder::class,
            EducationSeeder::class,
            RegencySeeder::class,
            PatientStatusSeeder::class,
            DistrictSeeder::class,
            StaticElementSeeder::class,
            SatelliteHealthFacilitySeeder::class,
        ]);

        // Sekawan's TB Jember
        \App\Models\User::factory()->create([
            'name' => 'Sekawan Jember',
            'email' => 'sekawanjember@gmail.com',
            'number' => '087712758168',
            'role' => 'superadmin',
        ]);

        // Divisi Komunikasi
        \App\Models\User::factory()->create([
            'name' => 'Divisi Komunikasi',
            'email' => 'divkom.sekawan@gmail.com',
            'number' => '085235508685',
            'role' => 'admin',
        ]);

        // Divisi IT Database
        \App\Models\User::factory()->create([
            'name' => 'Divisi IT Database',
            'email' => 'itdb.sekawan@gmail.com',
            'number' => '089626750089',
            'role' => 'admin',
        ]);

        // Admin PS
        \App\Models\User::factory()->create([
            'name' => 'Ahmad Zaini',
            'email' => 'zaini.sekawan@gmail.com',
            'number' => '085732480822',
            'role' => 'adminps',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Faisol Mansur',
            'email' => 'faisol.sekawan@gmail.com',
            'number' => '085816879136',
            'role' => 'adminps',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Rahayu',
            'email' => 'rahayu.sekawan@gmail.com',
            'number' => '085700000000',
            'role' => 'adminps',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Nafik',
            'email' => 'nafik.sekawan@gmail.com',
            'number' => '085700000000',
            'role' => 'adminps',
        ]);

        \App\Models\Article::factory($this->article)->createQuietly();
        \App\Models\EmergencyContact::factory($this->patient)->create();
        \App\Models\Patient::factory($this->patient)->create();
        \App\Models\PatientDetail::factory($this->patient)->create();
    }
}
