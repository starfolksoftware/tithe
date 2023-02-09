<?php

namespace Tithe;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tithe\Commands\TitheCommand;

class TitheServiceProvider extends PackageServiceProvider
{
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
            ->hasCommand(TitheCommand::class);
    }
}
