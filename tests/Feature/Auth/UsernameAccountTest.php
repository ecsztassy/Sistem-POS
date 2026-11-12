<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UsernameAccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_account_schema_has_no_contact_or_verification_columns(): void
    {
        $this->assertFalse(Schema::hasColumn('users', 'email'));
        $this->assertFalse(Schema::hasColumn('users', 'email_verified_at'));
        $this->assertFalse(Schema::hasTable('password_reset_tokens'));
    }

    public function test_obsolete_recovery_and_verification_endpoints_are_unavailable(): void
    {
        $this->get('/forgot-password')->assertNotFound();
        $this->post('/forgot-password')->assertNotFound();
        $this->get('/reset-password/token')->assertNotFound();
        $this->post('/reset-password')->assertNotFound();
        $this->actingAs(User::factory()->create());
        $this->get('/verify-email')->assertNotFound();
        $this->get('/verify-email/1/hash')->assertNotFound();
        $this->post('/email/verification-notification')->assertNotFound();
    }
}
