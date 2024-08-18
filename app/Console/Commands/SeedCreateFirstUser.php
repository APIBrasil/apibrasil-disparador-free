<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class SeedCreateFirstUser extends Command
{
    protected $signature = 'db:seed:createFirstUser {--email=} {--senha=}';
    protected $description = 'Seed para criar o primeiro usuário com email e senha fornecidos';

    public function handle()
    {
        $email = $this->option('email');
        $senha = $this->option('senha');

        if (!$email || !$senha) {
            $this->error('Você deve fornecer um email e uma senha.');
            return 1;
        }

        // Verifica se o usuário já existe
        if (User::where('email', $email)->exists()) {
            $this->error('Usuário com este email já existe.');
            return 1;
        }

        // Cria o usuário
        User::create([
            'name' => 'Admin',
            'email' => $email,
            'api_token' => Str::random(60),
            'password' => Hash::make($senha),
        ]);

        $this->info('Usuário criado com sucesso!');
        return 0;
    }
}
