<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vaccination;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BakunaTrackerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_protected_routes_to_login(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/schedule')->assertRedirect('/login');
    }

    public function test_guest_can_view_login_page_with_sign_in_link_in_nav(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee('Bakuna Tracker - Purok Buenviaje');
        $response->assertSee('Sign in');
        $response->assertDontSee('Logout');
    }

    public function test_seeded_health_worker_can_login_and_view_dashboard_and_schedule(): void
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'nurse.buenviaje@bakuna.test')->first();
        $this->assertNotNull($user);
        $this->assertTrue(Hash::check('bakuna2026', $user->password));

        $loginResponse = $this->post('/login', [
            'email' => 'nurse.buenviaje@bakuna.test',
            'password' => 'bakuna2026',
        ]);

        $loginResponse->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);

        $dashboardResponse = $this->get('/dashboard');
        $dashboardResponse->assertOk();
        $dashboardResponse->assertSee('Bakuna Tracker - Purok Buenviaje');
        $dashboardResponse->assertSee('Hi, '.explode(' ', $user->name)[0]);
        $dashboardResponse->assertSee('Logout');
        $dashboardResponse->assertSee('BCG');
        $dashboardResponse->assertSee('Pentavalent');
        $dashboardResponse->assertSee('OPV');
        $dashboardResponse->assertSee('MMR');
        $dashboardResponse->assertSee('Anti-Flu');

        $scheduleResponse = $this->get('/schedule');
        $scheduleResponse->assertOk();
        $scheduleResponse->assertSee('Master Immunization Schedule');
        $this->assertGreaterThanOrEqual(6, Vaccination::count());
    }

    public function test_invalid_login_credentials_return_validation_error(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->from('/login')->post('/login', [
            'email' => 'nurse.buenviaje@bakuna.test',
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_authenticated_user_can_logout(): void
    {
        $this->seed(DatabaseSeeder::class);
        $user = User::where('email', 'nurse.buenviaje@bakuna.test')->firstOrFail();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
