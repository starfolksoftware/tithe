<?php

namespace Tithe\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallCommand extends Command
{
    public $signature = 'install:tithe';

    public $description = 'Installs the tithe package and resources';

    public function handle(): int
    {
        // Publish...
        $this->callSilent('vendor:publish', ['--tag' => 'tithe-', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'tithe-migrations', '--force' => true]);

        // Models...
        // copy(__DIR__.'/../../stubs/app/Models/Recurrence.php', app_path('Models/Recurrence.php'));

        // Factories
        // copy(__DIR__.'/../../stubs/database/factories/RecurrenceFactory.php', app_path('../database/factories/RecurrenceFactory.php'));

        // Policies...
        // copy(__DIR__.'/../../stubs/app/Policies/RecurrencePolicy.php', app_path('Policies/RecurrencePolicy.php'));

        // Service Providers...
        // copy(__DIR__.'/../../stubs/app/Providers/RedoServiceProvider.php', app_path('Providers/RedoServiceProvider.php'));

        $this->installServiceProviderAfter('RouteServiceProvider', 'RedoServiceProvider');

        $this->comment('All done');

        return self::SUCCESS;
    }

    /**
     * Install the service provider in the application configuration file.
     *
     * @param  string  $after
     * @param  string  $name
     * @return void
     */
    protected function installServiceProviderAfter($after, $name)
    {
        if (! Str::contains($appConfig = file_get_contents(config_path('app.php')), 'App\\Providers\\'.$name.'::class')) {
            file_put_contents(config_path('app.php'), str_replace(
                'App\\Providers\\'.$after.'::class,',
                'App\\Providers\\'.$after.'::class,'.PHP_EOL.'        App\\Providers\\'.$name.'::class,',
                $appConfig
            ));
        }
    }
}
