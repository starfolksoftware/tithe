<?php

use Tithe\Tests\Mocks\TitheUser;
use Tithe\Tithe;

test('plans index page can be rendered', function () {
    $this->actingAs($user = TitheUser::factory()->create(), 'tithe');

    $response = $this->get(route('plans.index'));

    $response->assertStatus(200);
});

test('only loggedin users can see the plans index page', function () {
    $response = $this->get(route('plans.index'));

    $response->assertStatus(302);
});

test('create plan page can be rendered', function () {
    $this->actingAs($user = TitheUser::factory()->create(), 'tithe');

    $response = $this->get(route('plans.create'));

    $response->assertStatus(200);
});

test('plans can be created', function () {
    $this->actingAs($user = TitheUser::factory()->create(), 'tithe');

    $data = Tithe::planModel()::factory()->raw();

    $response = $this->post(route('plans.store'), $data);

    $response->assertRedirect();
    $plan = Tithe::planModel()::latest()->first();
    $response->assertRedirectToRoute('plans.show', $plan->id);
    expect($plan)
        ->name->toBe($data['name'])
        ->periodicity->toBe($data['periodicity'])
        ->periodicity_type->toBe($data['periodicity_type'])
        ->amount->toBe($data['amount']);
});

test('update plan page can be rendered', function () {
    $this->actingAs($user = TitheUser::factory()->create(), 'tithe');

    $plan = Tithe::planModel()::factory()->create();

    $response = $this->get(route('plans.edit', $plan->id));

    $response->assertStatus(200);
});

test('plan can be updated', function () {
    $this->actingAs($user = TitheUser::factory()->create(), 'tithe');

    $plan = Tithe::planModel()::factory()->create();
    $data = Tithe::planModel()::factory()->raw();

    $response = $this->put(route('plans.update', $plan->id), [
        'display_name' => $data['display_name'],
        'amount' => $data['amount'],
        'description' => $data['description'],
        'grace_days' => $data['grace_days'],
    ]);

    $response->assertRedirectToRoute('plans.show', $plan->id);
    expect($plan->fresh())
        ->display_name->toBe($data['display_name'])
        ->amount->toBe($data['amount'])
        ->description->toBe($data['description'])
        ->grace_days->toBe($data['grace_days']);
});

test('plan name can not be updated', function () {
    $this->actingAs($user = TitheUser::factory()->create(), 'tithe');

    $plan = Tithe::planModel()::factory()->create();
    $data = Tithe::planModel()::factory()->raw();

    $response = $this->put(route('plans.update', $plan->id), [
        'name' => 'name',
        'display_name' => $data['display_name'],
        'amount' => $data['amount'],
        'description' => $data['description'],
        'grace_days' => $data['grace_days'],
    ]);

    $response->assertRedirectToRoute('plans.show', $plan->id);
    expect($plan->fresh())
        ->name->toBe($plan->name);
});

test('plan can be deleted', function () {
    $this->actingAs($user = TitheUser::factory()->create(), 'tithe');

    $plan = Tithe::planModel()::factory()->create();

    $response = $this->delete(route('plans.destroy', $plan->id));

    $response->assertRedirectToRoute('plans.index');
    expect(Tithe::planModel()::count())->toBe(0);
});
