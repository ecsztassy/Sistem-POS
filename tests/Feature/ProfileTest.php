<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_and_update_profile(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user)->get('/profile')->assertOk();
        $this->patch('/profile', ['name' => 'Admin Toko', 'username' => 'admintoko'])->assertSessionHasNoErrors()->assertRedirect('/profile');
        $this->assertSame('Admin Toko', $user->fresh()->name);
        $this->assertSame('admintoko', $user->fresh()->username);
    }

    public function test_profile_username_must_be_unique(): void
    {
        User::factory()->create(['username' => 'taken']);
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user)->patch('/profile', ['name' => 'Admin', 'username' => 'taken'])
            ->assertSessionHasErrors('username');
        $this->assertSame($user->username, $user->fresh()->username);
    }

    public function test_unchanged_username_can_be_saved(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user)->patch('/profile', ['name' => 'Admin', 'username' => $user->username])
            ->assertSessionHasNoErrors();
    }

    public function test_self_service_account_deletion_is_disabled(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user)->delete('/profile', ['password' => 'password'])->assertStatus(405);
        $this->assertNotNull($user->fresh());
    }
}
