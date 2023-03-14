<?php

use Tithe\Tests\Mocks\TitheUser;
use Tithe\Tithe;

test('feature can be attached to a plan', function () {
    $this->actingAs($user = TitheUser::factory()->create(), 'tithe');

    $plan = Tithe::planModel()::factory()->create();
    $feature = Tithe::featureModel()::factory()->create();

    $response = $this->post(route('tithe.plans.attach-feature', $plan->id), [
        'feature_id' => $feature->id,
        'charges' => 50,
    ]);

    expect($plan->features()->count())->toBe(1);
    expect($plan->features()->latest()->first())
        ->pivot->charges->toBe(50);

    $response->assertRedirectToRoute('plans.show', $plan->id);
});
