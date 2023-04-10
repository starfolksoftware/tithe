<?php

namespace Tithe\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class InstallCommand extends Command
{
    public $signature = 'tithe:install';

    public $description = 'Installs the tithe package and resources';

    public function handle(): int
    {
        // Directories...
        (new Filesystem)->ensureDirectoryExists(app_path('Actions/Tithe'));
        (new Filesystem)->ensureDirectoryExists(public_path('vendor/tithe'));

        // Publish...
        $this->callSilent('vendor:publish', ['--tag' => 'tithe-', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'tithe-migrations', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'tithe-config', '--force' => true]);

        // Actions...
        copy(__DIR__.'/../../stubs/app/Actions/AttachFeatureToPlan.php', app_path('Actions/Tithe/AttachFeatureToPlan.php'));
        copy(__DIR__.'/../../stubs/app/Actions/CreateAuthorization.php', app_path('Actions/Tithe/CreateAuthorization.php'));
        copy(__DIR__.'/../../stubs/app/Actions/CreateFeature.php', app_path('Actions/Tithe/CreateFeature.php'));
        copy(__DIR__.'/../../stubs/app/Actions/CreatePlan.php', app_path('Actions/Tithe/CreatePlan.php'));
        copy(__DIR__.'/../../stubs/app/Actions/DetachFeatureFromPlan.php', app_path('Actions/Tithe/DetachFeatureFromPlan.php'));
        copy(__DIR__.'/../../stubs/app/Actions/UpdateFeature.php', app_path('Actions/Tithe/UpdateFeature.php'));
        copy(__DIR__.'/../../stubs/app/Actions/UpdatePlan.php', app_path('Actions/Tithe/UpdatePlan.php'));
        copy(__DIR__.'/../../stubs/app/Actions/UpgradeSubscription.php', app_path('Actions/Tithe/UpgradeSubscription.php'));
        copy(__DIR__.'/../../stubs/app/Actions/DowngradeSubscription.php', app_path('Actions/Tithe/DowngradeSubscription.php'));
        copy(__DIR__.'/../../stubs/app/Actions/CancelPendingDowngrade.php', app_path('Actions/Tithe/CancelPendingDowngrade.php'));
        copy(__DIR__.'/../../stubs/app/Actions/RenewSubscription.php', app_path('Actions/Tithe/RenewSubscription.php'));
        copy(__DIR__.'/../../stubs/app/Actions/HandleOverdueSubscription.php', app_path('Actions/Tithe/HandleOverdueSubscription.php'));

        // Models...
        copy(__DIR__.'/../../stubs/app/Models/TitheUser.php', app_path('Models/TitheUser.php'));
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
        copy(__DIR__.'/../../stubs/database/factories/TitheUserFactory.php', app_path('../database/factories/TitheUserFactory.php'));
        copy(__DIR__.'/../../stubs/database/factories/PlanFactory.php', app_path('../database/factories/PlanFactory.php'));
        copy(__DIR__.'/../../stubs/database/factories/SubscriptionFactory.php', app_path('../database/factories/SubscriptionFactory.php'));
        copy(__DIR__.'/../../stubs/database/factories/SubscriptionInvoiceFactory.php', app_path('../database/factories/SubscriptionInvoiceFactory.php'));
        copy(__DIR__.'/../../stubs/database/factories/SubscriptionRenewalFactory.php', app_path('../database/factories/SubscriptionRenewalFactory.php'));
        copy(__DIR__.'/../../stubs/database/factories/FeatureFactory.php', app_path('../database/factories/FeatureFactory.php'));
        copy(__DIR__.'/../../stubs/database/factories/FeatureConsumptionFactory.php', app_path('../database/factories/FeatureConsumptionFactory.php'));
        copy(__DIR__.'/../../stubs/database/factories/CreditCardFactory.php', app_path('../database/factories/CreditCardFactory.php'));
        copy(__DIR__.'/../../stubs/database/factories/CreditCardAuthorizationFactory.php', app_path('../database/factories/CreditCardAuthorizationFactory.php'));

        // Policies...
        copy(__DIR__.'/../../stubs/app/Policies/TitheUserPolicy.php', app_path('Policies/TitheUserPolicy.php'));
        copy(__DIR__.'/../../stubs/app/Policies/PlanPolicy.php', app_path('Policies/PlanPolicy.php'));
        copy(__DIR__.'/../../stubs/app/Policies/SubscriptionPolicy.php', app_path('Policies/SubscriptionPolicy.php'));
        copy(__DIR__.'/../../stubs/app/Policies/SubscriptionInvoicePolicy.php', app_path('Policies/SubscriptionInvoicePolicy.php'));
        copy(__DIR__.'/../../stubs/app/Policies/SubscriptionRenewalPolicy.php', app_path('Policies/SubscriptionRenewalPolicy.php'));
        copy(__DIR__.'/../../stubs/app/Policies/FeaturePolicy.php', app_path('Policies/FeaturePolicy.php'));
        copy(__DIR__.'/../../stubs/app/Policies/FeatureConsumptionPolicy.php', app_path('Policies/FeatureConsumptionPolicy.php'));
        copy(__DIR__.'/../../stubs/app/Policies/CreditCardPolicy.php', app_path('Policies/CreditCardPolicy.php'));
        copy(__DIR__.'/../../stubs/app/Policies/CreditCardAuthorizationPolicy.php', app_path('Policies/CreditCardAuthorizationPolicy.php'));

        // Tests...
        copy(__DIR__.'/../../stubs/tests/FeatureControllerTest.php', base_path('tests/Feature/FeatureControllerTest.php'));
        copy(__DIR__.'/../../stubs/tests/FeaturePlanAttachmentControllerTest.php', base_path('tests/Feature/FeaturePlanAttachmentControllerTest.php'));
        copy(__DIR__.'/../../stubs/tests/FeaturePlanDetachmentControllerTest.php', base_path('tests/Feature/FeaturePlanDetachmentControllerTest.php'));
        copy(__DIR__.'/../../stubs/tests/PlanControllerTest.php', base_path('tests/Feature/PlanControllerTest.php'));
        copy(__DIR__.'/../../stubs/tests/PaymentMethodTest.php', base_path('tests/Feature/PaymentMethodTest.php'));
        copy(__DIR__.'/../../stubs/tests/UpgradeSubscriptionTest.php', base_path('tests/Feature/UpgradeSubscriptionTest.php'));
        copy(__DIR__.'/../../stubs/tests/DowngradeSubscriptionTest.php', base_path('tests/Feature/DowngradeSubscriptionTest.php'));

        // Assets
        copy(__DIR__.'/../../resources/dist/tithe.css', public_path('vendor/tithe/main.css'));

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
