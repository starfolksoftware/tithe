<?php

use Tithe\Tests\Mocks\TitheUser;
use Tithe\Tithe;

test('feature can be detached from a plan', function () {
    $this->actingAs($user = TitheUser::factory()->create(), 'tithe');

    $feature = Tithe::featureModel()::factory()->hasAttached(
        [$plan] = Tithe::planModel()::factory()->count(1)->create(),
        ['charges' => 20]
    )->create();

    expect($plan->features()->count())->toBe(1);

    $response = $this->post(route('tithe.plans.detach-feature', $plan->id), [
        'feature_id' => $feature->id,
    ]);

    expect($plan->features()->count())->toBe(0);

    $response->assertRedirectToRoute('plans.show', $plan->id);
});
