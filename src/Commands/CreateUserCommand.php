<?php

namespace Tithe\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Helper\ProgressBar;
use Tithe\Enums\TitheUserRoleEnum;
use Tithe\Tithe;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tithe:create-user {name?} {email?} {password?} {role?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user for Tithe';

    protected string $userName;

    protected string $email;

    protected string $password;

    protected string $role; // admin

    protected ProgressBar $bar;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->bar = $this->output->createProgressBar(11);

        $this->userName = $this->argument('name') ?? $this->ask('What is the name?');
        $this->bar->advance();
        $this->newLine(3);

        $this->email = $this->argument('email') ?? $this->ask('What is the email?');
        $this->bar->advance();
        $this->newLine(3);

        $this->password = $this->argument('password') ?? $this->secret('What is the password?');
        $this->bar->advance();
        $this->newLine(3);

        $this->role = ($this->argument('role') && in_array($this->argument('role'), TitheUserRoleEnum::toCollection()->keys()->toArray())) ?
            $this->argument('role') :
            $this->choice(
                'What is the role of the user?',
                ['admin'],
                0
            );
        $this->bar->advance();
        $this->newLine(3);

        $user = Tithe::newUserModel();
        $user->fill([
            'name' => $this->userName,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'avatar' => Tithe::gravatar($this->email),
            'role' => $this->role,
        ]);

        $user->save();

        $this->info('New user created.');
        $this->table(['Email', 'Password'], [[$this->email, $this->password]]);
        $this->info('First things first, login at <info>'.route('tithe.login').'</info> and update your credentials.');
    }
}
