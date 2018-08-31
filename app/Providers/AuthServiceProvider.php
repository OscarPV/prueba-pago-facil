<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->input('api_token') == 'hola123.') {
                // Aquí se debería de checar el token con la base de datos como se sugiere,
                // pero por ser una prueba y al no existir el campo en la base sólo comprobaremos
                // la cadena.
                // User::where('api_token', $request->input('api_token'))->first();
                return new User;
            }
        });
    }
}
