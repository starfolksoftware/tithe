<?php

namespace App\Providers;

use App\Actions\Tithe as TitheActions;
use Illuminate\Support\ServiceProvider;
use Tithe\Tithe;

class TitheServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Tithe::createPlansUsing(TitheActions\CreatePlan::class);
        Tithe::updatePlansUsing(TitheActions\UpdatePlan::class);
        Tithe::createFeaturesUsing(TitheActions\CreateFeature::class);
        Tithe::updateFeaturesUsing(TitheActions\UpdateFeature::class);
        Tithe::attachFeaturesToPlansUsing(TitheActions\AttachFeatureToPlan::class);
        Tithe::detachFeaturesFromPlansUsing(TitheActions\DetachFeatureFromPlan::class);
        Tithe::createAuthorizationsUsing(TitheActions\CreateAuthorization::class);
        Tithe::upgradeSubscriptionsUsing(TitheActions\UpgradeSubscription::class);
        Tithe::downgradeSubscriptionsUsing(TitheActions\DowngradeSubscription::class);
        Tithe::cancelPendingUpgradesUsing(TitheActions\CancelPendingDowngrade::class);
        Tithe::renewSubscriptionsUsing(TitheActions\RenewSubscription::class);
        Tithe::getActiveSubscriberUsing(function () {
            // edit the following line
            return null;
        });
    }
}
