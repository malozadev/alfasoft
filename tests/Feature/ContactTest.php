<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@alfasoft.com',
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
            'email' => 'john@example.com', // Email diferente do usuário
            'contact' => '123456789', // Campo correto é 'contact', não 'phone'
            'address' => '123 Main Street, New York', // Address é obrigatório
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
            'contact' => '', // Adicionar campo contact
            'address' => '', // Adicionar campo address
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'contact', 'address']);
    }

    /** @test */
    public function contact_must_have_valid_data()
    {
        // Teste: nome muito curto
        $response = $this->actingAs($this->user)->post('/contacts', [
            'name' => 'Jo', // Menos de 5 caracteres
            'email' => 'john@example.com',
            'contact' => '123456789',
            'address' => 'Valid address with more than 5 chars',
        ]);
        $response->assertSessionHasErrors(['name']);

        // Teste: contact não tem 9 dígitos
        $response = $this->actingAs($this->user)->post('/contacts', [
            'name' => 'John Doe',
            'email' => 'john2@example.com',
            'contact' => '12345', // Apenas 5 dígitos
            'address' => 'Valid address with more than 5 chars',
        ]);
        $response->assertSessionHasErrors(['contact']);

        // Teste: address muito curto
        $response = $this->actingAs($this->user)->post('/contacts', [
            'name' => 'John Doe',
            'email' => 'john3@example.com',
            'contact' => '123456789',
            'address' => 'Add', // Menos de 5 caracteres
        ]);
        $response->assertSessionHasErrors(['address']);
    }

    /** @test */
    public function unauthenticated_user_cannot_create_contact()
    {
        $response = $this->post('/contacts', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'contact' => '123456789',
            'address' => '123 Main Street',
        ]);

        $response->assertRedirect('/login'); // Ou verifique se é redirecionado para login
    }

    /** @test */
    public function user_can_view_single_contact()
    {
        $contact = Contact::factory()->create([
            'name' => 'Test Contact',
            'email' => 'test@example.com',
            'contact' => '987654321',
            'address' => 'Test Address',
        ]);

        $response = $this->get("/contacts/{$contact->id}");
        $response->assertStatus(200);
        $response->assertSee('Test Contact');
    }

    /** @test */
    public function user_can_update_contact()
    {
        $contact = Contact::factory()->create([
            'email' => 'original@example.com',
            'contact' => '111111111',
        ]);

        $response = $this->actingAs($this->user)
            ->put("/contacts/{$contact->id}", [
                'name' => 'Updated Name',
                'email' => 'updated@example.com',
                'contact' => '222222222',
                'address' => 'Updated Address with more than 5 chars',
            ]);

        $response->assertRedirect('/contacts');
        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'contact' => '222222222',
        ]);
    }

    /** @test */
    public function user_can_delete_contact()
    {
        $contact = Contact::factory()->create();

        $response = $this->actingAs($this->user)
            ->delete("/contacts/{$contact->id}");

        $response->assertRedirect('/contacts');
        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
    }

    /** @test */
    public function email_must_be_unique_when_creating_contact()
    {
        // Primeiro cria um contato
        Contact::factory()->create([
            'email' => 'duplicate@example.com',
            'contact' => '111111111',
        ]);

        // Tenta criar outro com o mesmo email
        $response = $this->actingAs($this->user)->post('/contacts', [
            'name' => 'Another Contact',
            'email' => 'duplicate@example.com', // Email duplicado
            'contact' => '222222222',
            'address' => 'Some valid address',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function contact_must_be_unique_when_creating_contact()
    {
        // Primeiro cria um contato
        Contact::factory()->create([
            'email' => 'contact1@example.com',
            'contact' => '111111111',
        ]);

        // Tenta criar outro com o mesmo número de contato
        $response = $this->actingAs($this->user)->post('/contacts', [
            'name' => 'Another Contact',
            'email' => 'contact2@example.com',
            'contact' => '111111111', // Número de contato duplicado
            'address' => 'Some valid address',
        ]);

        $response->assertSessionHasErrors(['contact']);
    }
}
