<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    /**
     * Test that the password request page loads correctly.
     */
    public function test_password_request_page_loads(): void
    {
        $response = $this->get('/forgot-password');
        $response->assertStatus(200);
        $response->assertSee('Recuperar Password');
    }

    /**
     * Test that a password reset token is generated when requested.
     */
    public function test_password_reset_token_is_generated(): void
    {
        // Create a user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Request password reset
        $response = $this->post('/forgot-password', [
            'email' => 'test@example.com',
        ]);

        // Check that a token was created in the database
        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => 'test@example.com',
        ]);

        $response->assertSessionHas('status');
    }

    /**
     * Test the reset password form is displayed with a valid token.
     */
    public function test_reset_password_form_is_displayed(): void
    {
        // Create a token manually
        $token = 'test-token';
        $email = 'test@example.com';

        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now(),
        ]);

        // Get the reset password form
        $response = $this->get('/reset-password/' . $token . '?email=' . urlencode($email));

        $response->assertStatus(200);
        $response->assertSee('Redefinir Password');
    }

    /**
     * Test that a user can reset their password.
     */
    public function test_user_can_reset_password(): void
    {
        // Create a user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('old-password'),
        ]);

        // Create a token manually
        $token = 'test-token';
        $email = 'test@example.com';

        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now(),
        ]);

        // Reset the password
        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => $email,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        // Verify the user can log in with the new password
        $this->assertTrue(Auth::attempt([
            'email' => $email,
            'password' => 'new-password',
        ]));
    }
}
