<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\PatientStatus;
use App\Models\SatelliteHealthFacility;
use App\Models\User; 
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 * <\App\Models\PatientDetail>
 */
class PatientDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $patient = Patient::select('id')->get();
        $satellite = SatelliteHealthFacility::count();
        // $worker = Worker::count(); 
        $user = User::count(); 
        $status = PatientStatus::count();
        return [
            'patient_id' => fake()->unique()->randomElement($patient),
            'satellite_health_facility_id' => fake()->numberBetween(1, $satellite),
            // 'worker_id' => fake()->numberBetween(1, $worker), 
            'user_id' => fake()->numberBetween(1, $user),
            'no_regis' => fake()->unique()->numerify('##########'),
            'patient_status_id' => fake()->numberBetween(1, $status),
            'age' => fake()->numberBetween(3, 80),
            'weight' => fake()->numberBetween(10, 80),
            'height' => fake()->numberBetween(40, 200),
        ];
    }
}
