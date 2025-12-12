<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Criar o usuário admin quando a aplicação iniciar
        $this->createAdminUser();
    }

    /**
     * Create admin user if not exists
     */
    private function createAdminUser(): void
    {
        // Usar sua lógica de seeder
        if (!app()->runningInConsole()) { // Não executar em comandos artisan
            User::updateOrCreate(
                ['email' => 'admin@alfasoft.com'],
                [
                    'name' => 'admin',
                    'password' => Hash::make('123456'),
                ]
            );
        }
    }
}
