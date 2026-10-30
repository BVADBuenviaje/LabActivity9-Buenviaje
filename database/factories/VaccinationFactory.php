<?php

namespace Database\Factories;

use App\Models\Vaccination;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vaccination>
 */
class VaccinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_name' => fake()->name(),
            'purok' => fake()->randomElement([
                'Purok Buenviaje',
                'Purok 1 - Matina Crossing',
                'Purok 2 - Matina Crossing',
                'Purok 3 - Matina Crossing',
            ]),
            'address' => 'Davao City',
            'vaccine' => fake()->randomElement([
                'BCG',
                'Pentavalent',
                'OPV',
                'MMR',
                'Anti-Flu',
                'PCV-13',
            ]),
            'dose' => fake()->randomElement(['Dose 1', 'Dose 2', 'Dose 3', 'Booster']),
            'scheduled_at' => fake()->dateTimeBetween('2026-01-01', '2026-12-31')->format('Y-m-d'),
            'status' => fake()->randomElement(['Completed', 'Scheduled', 'Pending']),
        ];
    }
}
