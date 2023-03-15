<?php

namespace App\Providers;

use App\Actions\Tithe\{AttachFeatureToPlan, CreateFeature, CreatePlan, DetachFeatureFromPlan, UpdateFeature, UpdatePlan};
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
        Tithe::createPlansUsing(CreatePlan::class);
        Tithe::updatePlansUsing(UpdatePlan::class);
        Tithe::createFeaturesUsing(CreateFeature::class);
        Tithe::updateFeaturesUsing(UpdateFeature::class);
        Tithe::attachFeaturesToPlansUsing(AttachFeatureToPlan::class);
        Tithe::detachFeaturesFromPlansUsing(DetachFeatureFromPlan::class);
    }
}
