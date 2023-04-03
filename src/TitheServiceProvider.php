<?php

namespace Tithe;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tithe\Commands;
use Tithe\View\Components;

/**
 * Tithe\TitheServiceProvider
 *
 * @property mixed $config
 */
class TitheServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        parent::boot();
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('tithe')
            ->hasConfigFile()
            ->hasViews()
            ->hasCommand(Commands\InstallCommand::class)
            ->hasCommand(Commands\CreateUserCommand::class)
            ->hasViewComponent('tithe', Components\PaymentMethodManager::class)
            ->hasViewComponent('tithe', Components\SubscriptionManager::class);

        if (! config('tithe.ignores_routes')) {
            $package->hasRoute('web');
        }

        if (! config('tithe.ignores_migrations')) {
            $package->hasMigration('create_tithe_table');
        }

        $this->registerAuthDriver();
    }

    /**
     * Register the package's authentication driver.
     */
    private function registerAuthDriver(): void
    {
        $this->app->config->set('auth.providers.tithe_users', [
            'driver' => 'eloquent',
            'model' => Tithe::userModel(),
        ]);

        $this->app->config->set('auth.guards.tithe', [
            'driver' => 'session',
            'provider' => 'tithe_users',
        ]);
    }
}
