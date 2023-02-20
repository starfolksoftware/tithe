<?php

use Tithe\Tithe;
use Illuminate\Foundation\Testing\WithFaker;

beforeAll(function () {
    setTestModels();
});

uses(WithFaker::class);

test('feature plan model can retrieve plan', function () {
    $feature = Tithe::newFeatureModel()::factory()->create();

    $plan = Tithe::newPlanModel()::factory()->create();
    $plan->features()->attach($feature);

    $featurePlanPivot = Tithe::newFeaturePlanModel()::first();

    $this->assertEquals($plan->id, $featurePlanPivot->plan->id);
});

test('feature plan model can retrieve feature', function () {
    $feature = Tithe::newFeatureModel()::factory()->create();

    $plan = Tithe::newPlanModel()::factory()->create();
    $plan->features()->attach($feature->id);

    $featurePlanPivot = Tithe::featurePlanModel()::first();

    $this->assertEquals($feature->id, $featurePlanPivot->feature->id);
});
