<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('123456'),
        ]);
    }

    /** @test */
    public function guest_can_view_contacts()
    {
        $response = $this->get('/contacts');
        $response->assertStatus(200);
    }

    /** @test */
    public function authenticated_user_can_create_contact()
    {
        $response = $this->actingAs($this->user)->post('/contacts', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789',
        ]);

        $response->assertRedirect('/contacts');
        $this->assertDatabaseHas('contacts', ['email' => 'john@example.com']);
    }

    /** @test */
    public function validation_errors_are_returned_when_adding_contact()
    {
        $response = $this->actingAs($this->user)->post('/contacts', [
            'name' => '',
            'email' => 'not-an-email',
        ]);

        $response->assertSessionHasErrors(['name', 'email']);
    }
}
