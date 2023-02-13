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
        copy(__DIR__.'/../../stubs/app/Models/Subscription.php', app_path('Models/Subscription.php'));
        copy(__DIR__.'/../../stubs/app/Models/SubscriptionInvoice.php', app_path('Models/SubscriptionInvoice.php'));
        copy(__DIR__.'/../../stubs/app/Models/SubscriptionRenewal.php', app_path('Models/SubscriptionRenewal.php'));
        copy(__DIR__.'/../../stubs/app/Models/Feature.php', app_path('Models/Feature.php'));
        copy(__DIR__.'/../../stubs/app/Models/FeaturePlan.php', app_path('Models/FeaturePlan.php'));
        copy(__DIR__.'/../../stubs/app/Models/FeatureConsumption.php', app_path('Models/FeatureConsumption.php'));
        copy(__DIR__.'/../../stubs/app/Models/CreditCard.php', app_path('Models/CreditCard.php'));
        copy(__DIR__.'/../../stubs/app/Models/CreditCardAuthorization.php', app_path('Models/CreditCardAuthorization.php'));
        

        // Factories
        copy(__DIR__.'/../../stubs/database/factories/PlanFactory.php', app_path('../database/factories/PlanFactory.php'));
        copy(__DIR__.'/../../stubs/database/factories/SubscriptionFactory.php', app_path('../database/factories/SubscriptionFactory.php'));
        copy(__DIR__.'/../../stubs/database/factories/SubscriptionInvoiceFactory.php', app_path('../database/factories/SubscriptionInvoiceFactory.php'));
        copy(__DIR__.'/../../stubs/database/factories/SubscriptionInvoicePaymentFactory.php', app_path('../database/factories/SubscriptionInvoicePaymentFactory.php'));
        copy(__DIR__.'/../../stubs/database/factories/SubscriptionRenewalFactory.php', app_path('../database/factories/SubscriptionRenewalFactory.php'));
        copy(__DIR__.'/../../stubs/database/factories/FeatureFactory.php', app_path('../database/factories/FeatureFactory.php'));
        copy(__DIR__.'/../../stubs/database/factories/FeatureConsumptionFactory.php', app_path('../database/factories/FeatureConsumptionFactory.php'));
        copy(__DIR__.'/../../stubs/database/factories/CreditCardFactory.php', app_path('../database/factories/CreditCardFactory.php'));
        copy(__DIR__.'/../../stubs/database/factories/CreditCardAuthorizationFactory.php', app_path('../database/factories/CreditCardAuthorizationFactory.php'));
        

        // Policies...
        copy(__DIR__.'/../../stubs/app/Policies/PlanPolicy.php', app_path('Policies/PlanPolicy.php'));
        copy(__DIR__.'/../../stubs/app/Policies/SubscriptionPolicy.php', app_path('Policies/SubscriptionPolicy.php'));
        copy(__DIR__.'/../../stubs/app/Policies/SubscriptionInvoicePolicy.php', app_path('Policies/SubscriptionInvoicePolicy.php'));
        copy(__DIR__.'/../../stubs/app/Policies/SubscriptionInvoicePaymentPolicy.php', app_path('Policies/SubscriptionInvoicePaymentPolicy.php'));
        copy(__DIR__.'/../../stubs/app/Policies/SubscriptionRenewalPolicy.php', app_path('Policies/SubscriptionRenewalPolicy.php'));
        copy(__DIR__.'/../../stubs/app/Policies/FeaturePolicy.php', app_path('Policies/FeaturePolicy.php'));
        copy(__DIR__.'/../../stubs/app/Policies/FeatureConsumptionPolicy.php', app_path('Policies/FeatureConsumptionPolicy.php'));
        copy(__DIR__.'/../../stubs/app/Policies/CreditCardPolicy.php', app_path('Policies/CreditCardPolicy.php'));
        copy(__DIR__.'/../../stubs/app/Policies/CreditCardAuthorizationPolicy.php', app_path('Policies/CreditCardAuthorizationPolicy.php'));
        

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
