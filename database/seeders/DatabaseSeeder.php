<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    // default health worker and vaccination records
    public function run(): void
    {
        User::create([
            'name' => 'Brian',
            'email' => 'nurse.buenviaje@bakuna.test',
            'password' => Hash::make('bakuna2026'),
        ]);

        $this->call(VaccinationSeeder::class);
    }
}
