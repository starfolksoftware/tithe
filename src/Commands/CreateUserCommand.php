<?php

namespace Tithe\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Tithe\Enums\TitheUserEnum;
use Tithe\Tithe;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tithe:user
                    { role : The role to be assigned (admin, support) }
                    { --email= : Email associated with the user }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user for Tithe';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (! filter_var($this->option('email'), FILTER_VALIDATE_EMAIL)) {
            $this->error('Please enter a valid email.');

            return;
        }

        $email = $this->option('email');
        $password = 'password';

        $user = Tithe::newUserModel();
        $user->fill([
            'email' => $email,
            'password' => Hash::make($password),
            'avatar' => Tithe::gravatar($email),
        ]);

        switch ($this->argument('role')) {
            case 'admin':
                $user->fill([
                    'name' => 'New Admin',
                    'role' => TitheUserEnum::ADMIN->value,
                ]);
                break;

            case 'support':
                $user->fill([
                    'name' => 'New Support',
                    'role' => TitheUserEnum::SUPPORT->value,
                ]);
                break;

            default:
                $this->error('Please enter a valid role.');

                return;
        }

        $user->save();

        $this->info('New user created.');
        $this->table(['Email', 'Password'], [[$email, $password]]);
        $this->info('First things first, login at <info>'.route('tithe.login').'</info> and update your credentials.');
    }
}