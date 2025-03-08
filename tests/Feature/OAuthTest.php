<?php

use Illuminate\Support\Facades\Http;
use function Pest\Laravel\get;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use function Pest\Laravel\assertAuthenticated;

test('la ruta de autenticación redirige correctamente a GitHub', function () {
    $response = get('/auth/redirect');

    $response->assertRedirect(); // Verifica que redirige a OAuth
});

test('el callback de OAuth crea o autentica al usuario', function () {
    Http::fake();

    Socialite::shouldReceive('driver->user')
        ->once()
        ->andReturn(new class {
            public function getId()
            {
                return 12345;
            }
            public function getName()
            {
                return 'Test User';
            }
            public function getEmail()
            {
                return 'test@example.com';
            }
        });

    $response = get('/auth/callback');

    $response->assertRedirect('/dashboard'); // Asegura que redirige después del login
    assertAuthenticated(); // Confirma que el usuario está autenticado
});

test('los usuarios no autenticados no pueden acceder al dashboard', function () {
    $response = get('/dashboard');

    $response->assertRedirect('/login'); // Laravel debería redirigir al login
});
