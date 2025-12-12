<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     * Executa automaticamente quando a aplicação inicia
     */
    public function boot(): void
    {
        if (!$this->app->runningInConsole() && $this->isDatabaseReady()) {
            $this->ensureAdminUserExists();
        }
    }

    /**
     * Verifica se o banco de dados está pronto
     */
    private function isDatabaseReady(): bool
    {
        try {
            // Tenta verificar se a tabela users existe
            DB::connection()->getPdo();
            return Schema::hasTable('users');
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Cria o usuário admin se não existir
     */
    private function ensureAdminUserExists(): void
    {
        try {
            $adminUser = User::updateOrCreate(
                ['email' => 'admin@alfasoft.com'],
                [
                    'name' => 'admin',
                    'password' => Hash::make('123456'),
                ]
            );

            // Log informativo (opcional)
            Log::info('Admin user ensured: ' . $adminUser->email);

        } catch (\Exception $e) {
            Log::error('Failed to create admin user: ' . $e->getMessage());
        }
    }
}
