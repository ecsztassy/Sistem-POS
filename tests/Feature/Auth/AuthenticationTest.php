<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200)->assertSee('name="username"', false)->assertSee(route('register'))->assertDontSee('login-story');
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('pos.index', absolute: false));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'username' => $user->username,
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('username');

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    public function test_admin_login_redirects_to_dashboard_and_remembers_user(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->post('/login', ['username' => $user->username, 'password' => 'password', 'remember' => 'on'])
            ->assertRedirect(route('dashboard', absolute: false))
            ->assertCookie(auth()->guard()->getRecallerName());
        $this->assertAuthenticatedAs($user);
    }

    public function test_username_is_required_to_log_in(): void
    {
        $this->post('/login', ['password' => 'password'])
            ->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    public function test_login_attempts_are_throttled_by_username(): void
    {
        $user = User::factory()->create(['username' => 'throttleduser']);
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post('/login', ['username' => $user->username, 'password' => 'wrong-password'])
                ->assertSessionHasErrors('username');
        }
        $this->post('/login', ['username' => $user->username, 'password' => 'password'])
            ->assertSessionHasErrors('username');
        $this->assertGuest();

        RateLimiter::clear('throttleduser|127.0.0.1');
        $this->post('/login', ['username' => $user->username, 'password' => 'password'])
            ->assertSessionHasNoErrors();
        $this->assertAuthenticatedAs($user);
    }
}
