<?php

namespace Database\Seeders;

use App\Models\Vaccination;
use Illuminate\Database\Seeder;

class VaccinationSeeder extends Seeder
{
    // initial vaccination records
    public function run(): void
    {
        $entries = [
            [
                'patient_name' => 'Brian Buenviaje',
                'purok' => 'Purok Buenviaje',
                'address' => 'Davao City',
                'vaccine' => 'BCG',
                'dose' => 'Single Dose (At Birth)',
                'scheduled_at' => '2026-08-15',
                'status' => 'Completed',
            ],
            [
                'patient_name' => 'Althea Mae Santos',
                'purok' => 'Purok Buenviaje',
                'address' => 'Davao City',
                'vaccine' => 'Pentavalent',
                'dose' => 'Dose 1 of 3',
                'scheduled_at' => '2026-03-15',
                'status' => 'Completed',
            ],
            [
                'patient_name' => 'Gabriel Mendoza',
                'purok' => 'Purok 2 - Matina Crossing',
                'address' => 'Davao City',
                'vaccine' => 'OPV',
                'dose' => 'Dose 2 of 3',
                'scheduled_at' => '2026-05-18',
                'status' => 'Completed',
            ],
            [
                'patient_name' => 'Sofia Isabella Cruz',
                'purok' => 'Purok Buenviaje',
                'address' => 'Davao City',
                'vaccine' => 'MMR',
                'dose' => 'Dose 1 (9 Months)',
                'scheduled_at' => '2026-07-24',
                'status' => 'Scheduled',
            ],
            [
                'patient_name' => 'Lola Teresita Reyes',
                'purok' => 'Purok 3 - Matina Crossing',
                'address' => 'Davao City',
                'vaccine' => 'Anti-Flu',
                'dose' => 'Annual Booster 2026',
                'scheduled_at' => '2026-09-12',
                'status' => 'Scheduled',
            ],
            [
                'patient_name' => 'Lucas Miguel Villanueva',
                'purok' => 'Purok Buenviaje',
                'address' => 'Davao City',
                'vaccine' => 'PCV-13 (Pneumococcal)',
                'dose' => 'Dose 1 of 3',
                'scheduled_at' => '2026-11-05',
                'status' => 'Pending',
            ],
            [
                'patient_name' => 'Hannah Grace Dela Cruz',
                'purok' => 'Purok 1 - Matina Crossing',
                'address' => 'Davao City',
                'vaccine' => 'Pentavalent',
                'dose' => 'Dose 2 of 3',
                'scheduled_at' => '2026-11-19',
                'status' => 'Scheduled',
            ],
            [
                'patient_name' => 'Ethan Jacob Bautista',
                'purok' => 'Purok Buenviaje',
                'address' => 'Davao City',
                'vaccine' => 'Hepatitis B',
                'dose' => 'Birth Dose',
                'scheduled_at' => '2026-12-08',
                'status' => 'Pending',
            ],
        ];

        foreach ($entries as $entry) {
            Vaccination::create($entry);
        }
    }
}
