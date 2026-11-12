<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    private function registrationData(array $overrides = []): array
    {
        return array_replace([
            'name' => 'Test User',
            'username' => 'testuser',
            'password' => 'password',
            'password_confirmation' => 'password',
        ], $overrides);
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $this->get('/register')->assertOk()->assertSee('Nama Lengkap')->assertSee('Username')->assertSee(route('login'));
    }

    public function test_registration_creates_a_cashier_and_ignores_submitted_role(): void
    {
        Event::fake([Registered::class]);
        $response = $this->post('/register', $this->registrationData(['role' => 'admin']));

        $user = User::where('username', 'testuser')->firstOrFail();
        $this->assertAuthenticatedAs($user);
        $this->assertSame('kasir', $user->role);
        $this->assertTrue(Hash::check('password', $user->password));
        Event::assertDispatched(Registered::class);
        $response->assertRedirect(route('pos.index'));
        $this->get(route('dashboard'))->assertForbidden();
    }

    public function test_username_must_be_unique(): void
    {
        User::factory()->create(['username' => 'testuser']);

        $this->post('/register', $this->registrationData())->assertSessionHasErrors('username');
        $this->assertGuest();
        $this->assertDatabaseCount('users', 1);
    }

    #[DataProvider('invalidRegistrationData')]
    public function test_invalid_registration_is_rejected(array $values, string $field): void
    {
        $this->post('/register', $this->registrationData($values))->assertSessionHasErrors($field);
        $this->assertGuest();
        $this->assertDatabaseCount('users', 0);
    }

    public static function invalidRegistrationData(): array
    {
        return [
            'missing name' => [['name' => ''], 'name'],
            'long name' => [['name' => str_repeat('a', 256)], 'name'],
            'missing username' => [['username' => ''], 'username'],
            'long username' => [['username' => str_repeat('a', 256)], 'username'],
            'short password' => [['password' => 'short', 'password_confirmation' => 'short'], 'password'],
            'unconfirmed password' => [['password_confirmation' => 'different'], 'password'],
        ];
    }

    public function test_authenticated_users_cannot_register_another_account(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/register', $this->registrationData())->assertRedirect();
        $this->assertDatabaseCount('users', 1);
    }
}
