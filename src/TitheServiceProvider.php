<?php

namespace Tithe;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tithe\Commands\CreateUserCommand;
use Tithe\Commands\InstallCommand;

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
            ->hasMigration('create_tithe_table')
            ->hasCommand(InstallCommand::class)
            ->hasCommand(CreateUserCommand::class)
            ->hasRoute('web');

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
