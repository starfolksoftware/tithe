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
        copy(__DIR__.'/../../stubs/app/Models/Plan.php', app_path('Models/Plan.php'));
        copy(__DIR__.'/../../stubs/app/Models/Feature.php', app_path('Models/Feature.php'));
        copy(__DIR__.'/../../stubs/app/Models/FeaturePlan.php', app_path('Models/FeaturePlan.php'));
        copy(__DIR__.'/../../stubs/app/Models/Subscription.php', app_path('Models/Subscription.php'));

        // Factories
        copy(__DIR__.'/../../stubs/database/factories/PlanFactory.php', app_path('../database/factories/PlanFactory.php'));
        copy(__DIR__.'/../../stubs/database/factories/FeatureFactory.php', app_path('../database/factories/FeatureFactory.php'));
        copy(__DIR__.'/../../stubs/database/factories/SubscriptionFactory.php', app_path('../database/factories/SubscriptionFactory.php'));

        // Policies...
        copy(__DIR__.'/../../stubs/app/Policies/PlanPolicy.php', app_path('Policies/PlanPolicy.php'));
        copy(__DIR__.'/../../stubs/app/Policies/FeaturePolicy.php', app_path('Policies/FeaturePolicy.php'));
        copy(__DIR__.'/../../stubs/app/Policies/SubscriptionPolicy.php', app_path('Policies/SubscriptionPolicy.php'));

        // Service Providers...
        copy(__DIR__.'/../../stubs/app/Providers/TitheServiceProvider.php', app_path('Providers/TitheServiceProvider.php'));

        $this->installServiceProviderAfter('RouteServiceProvider', 'TitheServiceProvider');

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
