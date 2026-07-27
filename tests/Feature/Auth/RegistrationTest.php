<?php

namespace Tests\Feature\Auth;

use App\Models\Unidade;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_registration_redirects_to_totem_register_modal(): void
    {
        $response = $this->get('/register');

        $response->assertRedirect(route('totem.home', ['modal' => 'register'], false));
    }

    public function test_operator_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register-operador');

        $response->assertStatus(200);
        $response->assertSee('Cadastro de operador');
        $response->assertSee('Gestão de operadores');
        $response->assertDontSee('aluno');
        $response->assertDontSee('alunos');
    }

    public function test_unit_admin_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register-admin-unidade');

        $response->assertStatus(200);
        $response->assertSee('Cadastro de admin da unidade');
        $response->assertSee('Gestão administrativa da unidade');
        $response->assertDontSee('aluno');
        $response->assertDontSee('alunos');
    }

    public function test_new_students_can_register(): void
    {
        $unidade = Unidade::query()->first();

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'unidade_id' => $unidade->id,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard', absolute: false));

        $user = User::where('email', 'test@example.com')->first();
        $this->assertTrue($user->hasRole('estudante'));
    }

    public function test_new_operators_can_register(): void
    {
        $unidade = Unidade::query()->first();

        $response = $this->post('/register-operador', [
            'name' => 'Operator User',
            'email' => 'operator@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'unidade_id' => $unidade->id,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard', absolute: false));

        $user = User::where('email', 'operator@example.com')->first();
        $this->assertTrue($user->hasRole('operador'));
    }

    public function test_new_unit_admins_can_register(): void
    {
        $unidade = Unidade::query()->first();

        $response = $this->post('/register-admin-unidade', [
            'name' => 'Unit Admin User',
            'email' => 'unit-admin@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'unidade_id' => $unidade->id,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard', absolute: false));

        $user = User::where('email', 'unit-admin@example.com')->first();
        $this->assertTrue($user->hasRole('admin_unidade'));
    }

    public function test_super_admin_can_see_registration_links_on_dashboard(): void
    {
        $unidade = Unidade::query()->first();
        $user = User::factory()->create(['unidade_id' => $unidade->id]);

        Role::findOrCreate('super_admin');
        $user->assignRole('super_admin');

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Links de cadastro');
        $response->assertSee(route('register.operator'));
        $response->assertSee(route('register.unit-admin'));
    }

    public function test_operator_cannot_see_registration_links_on_dashboard(): void
    {
        $unidade = Unidade::query()->first();
        $user = User::factory()->create(['unidade_id' => $unidade->id]);

        Role::findOrCreate('operador');
        $user->assignRole('operador');

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(200);
        $response->assertDontSee('Links de cadastro');
        $response->assertDontSee(route('register.operator'));
        $response->assertDontSee(route('register.unit-admin'));
    }
}
