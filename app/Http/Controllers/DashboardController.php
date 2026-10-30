<?php

namespace App\Http\Controllers;

use App\Models\Vaccination;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    // dashboard summary
    public function index(): View
    {
        $vaccinations = Vaccination::query()
            ->orderBy('scheduled_at')
            ->get();

        $totalVaccinations = $vaccinations->count();
        $completedCount = $vaccinations->where('status', 'Completed')->count();
        $scheduledCount = $vaccinations->where('status', 'Scheduled')->count();
        $pendingCount = $vaccinations->where('status', 'Pending')->count();
        $purokBuenviajeCount = $vaccinations->where('purok', 'Purok Buenviaje')->count();
        $distinctVaccines = $vaccinations->pluck('vaccine')->unique()->values();

        return view('dashboard', [
            'vaccinations' => $vaccinations,
            'totalVaccinations' => $totalVaccinations,
            'completedCount' => $completedCount,
            'scheduledCount' => $scheduledCount,
            'pendingCount' => $pendingCount,
            'purokBuenviajeCount' => $purokBuenviajeCount,
            'distinctVaccines' => $distinctVaccines,
        ]);
    }

    // schedule directory
    public function schedule(Request $request): View
    {
        $selectedStatus = $request->query('status');
        $selectedPurok = $request->query('purok');

        $query = Vaccination::query()->orderBy('scheduled_at');

        if (is_string($selectedStatus) && $selectedStatus !== '') {
            $query->where('status', $selectedStatus);
        }

        if (is_string($selectedPurok) && $selectedPurok !== '') {
            $query->where('purok', $selectedPurok);
        }

        $vaccinations = $query->get();
        $allVaccinations = Vaccination::all();

        return view('schedule', [
            'vaccinations' => $vaccinations,
            'totalVaccinations' => $allVaccinations->count(),
            'completedCount' => $allVaccinations->where('status', 'Completed')->count(),
            'scheduledCount' => $allVaccinations->where('status', 'Scheduled')->count(),
            'pendingCount' => $allVaccinations->where('status', 'Pending')->count(),
            'puroks' => $allVaccinations->pluck('purok')->unique()->values(),
            'selectedStatus' => $selectedStatus,
            'selectedPurok' => $selectedPurok,
        ]);
    }
}
