<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class LoginControllerTest extends TestCase {

    use RefreshDatabase,
        WithFaker;

    /** @test */
    public function testExample() {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function test_login_displays_the_login_form() {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function test_login_displays_validation_errors() {
        $response = $this->post('/login', []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
        }

        /** @test */
        public function test_login_authenticates_and_redirects_user() {
        /*
          $name = $this->faker->name;
          $email = $this->faker->safeEmail;
          $password = $this->faker->password(8);

          $response = $this->post('register', [
          'name' => $name,
          'email' => $email,
          'password' => $password,
          'password_confirmation' => $password,
          ]);

          $response->assertRedirect(route('home'));

          $this->assertDatabaseHas('users', [
          'name' => $name,
          'email' => $email
          ]);
         * 
         */
        

        $user = factory(User::class)->create();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
public function test_register_creates_and_authenticates_a_user()
{
    $name = $this->faker->name;
    $email = $this->faker->safeEmail;
    $password = $this->faker->password(8);

    $response = $this->post('register', [
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'password_confirmation' => $password,
    ]);

    $response->assertRedirect(route('home'));

    $user = User::where('email', $email)->where('name', $name)->first();
    $this->assertNotNull($user);

    $this->assertAuthenticatedAs($user);
}
    
}
