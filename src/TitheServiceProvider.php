<?php

namespace Tithe;

use Illuminate\Support\Facades\Gate;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tithe\Actions\AttachFeatureToPlan;
use Tithe\Actions\CreateFeature;
use Tithe\Actions\CreatePlan;
use Tithe\Actions\DetachFeatureFromPlan;
use Tithe\Actions\UpdateFeature;
use Tithe\Actions\UpdatePlan;
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

        Tithe::createPlansUsing(CreatePlan::class);
        Tithe::updatePlansUsing(UpdatePlan::class);
        Tithe::createFeaturesUsing(CreateFeature::class);
        Tithe::updateFeaturesUsing(UpdateFeature::class);
        Tithe::attachFeaturesToPlansUsing(AttachFeatureToPlan::class);
        Tithe::detachFeaturesFromPlansUsing(DetachFeatureFromPlan::class);

        Gate::before(function ($user, string $ability) {
            if ($user->role === 'admin') {
                return true;
            }
        });
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
