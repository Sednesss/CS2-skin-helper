<?php

namespace App\Console\Commands\User;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class SetOwner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-owner {--email= : Email for the user} {--password= : Password for the user} {--name=Unknown : Username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Registering a user with owner rights';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->option('email');
        $password = $this->option('password');
        $name = $this->option('name');

        // email validation
        if (User::where('email', $email)->exists()) {
            $this->error('> ERROR. User with this email already exists');
            return;
        }

        // password validation
        if (strlen($password) < 8) {
            $this->error('> ERROR. Password should be at least 8 characters long');
            return;
        }

        $user = User::create([
            'email' => $email,
            'password' => Hash::make($password),
            'name' => $name,
        ]);
        $user->assignRole(User::ROLE_OWNER);
        $user->removeRole(User::ROLE_BASIC);

        $this->info('User created successfully');
    }
}
