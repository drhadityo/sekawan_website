<?php

namespace Database\Factories;

use App\Models\District;
use App\Models\EmergencyContact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 * <\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $emergency = EmergencyContact::count();
        $district = District::select('id')->get();
        $has_job = fake()->boolean();
        if ($has_job) {
            $place = fake()->company();
            $addr = fake()->streetAddress();
        }

        return [
            'name' => fake()->name(),
            'sex' => fake()->randomElement(['laki-laki', 'perempuan']),
            'education_id' => fake()->numberBetween(1, 5),
            'id_card_address' => fake()->streetAddress(),
            'id_number' => fake()->unique()->numerify('################'),
            'religion_id' => fake()->numberBetween(1, 6),
            'residence_address' => fake()->streetAddress(),
            'district_id' => fake()->randomElement($district),
            'phone' => fake()->unique()->numerify('##########'),
            'marital_status' => fake()->randomElement(['menikah', 'belum menikah', 'janda/duda']),
            'has_job' => $has_job,
            'workplace' => $place ?? null,
            'work_address' => $addr ?? null,
            'dependent' => fake()->numberBetween(1, 21),
            'mother_name' => fake()->name('female'),
            'father_name' => fake()->name('mele'),
            'guardian_phone' => fake()->numerify('################'),
            'guardian_address' => fake()->streetAddress(),
            'emergency_contact_id' => fake()->unique()->numberBetween(1, $emergency),
            'start_treatment' => fake()->date(),
        ];
    }
}
