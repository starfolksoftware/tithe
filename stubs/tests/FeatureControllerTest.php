<?php

use App\Models\TitheUser;
use Tithe\Tithe;

test('features index page can be rendered', function () {
    $this->actingAs($user = TitheUser::factory()->create(), 'tithe');

    $response = $this->get(route('features.index'));

    $response->assertStatus(200);
});

test('only loggedin users can see the features index page', function () {
    $response = $this->get(route('features.index'));

    $response->assertStatus(302);
});

test('create feature page can be rendered', function () {
    $this->actingAs($user = TitheUser::factory()->create(), 'tithe');

    $response = $this->get(route('features.create'));

    $response->assertStatus(200);
});

test('features can be created', function () {
    $this->actingAs($user = TitheUser::factory()->create(), 'tithe');

    $data = Tithe::featureModel()::factory()->raw();

    $response = $this->post(route('features.store'), $data);

    $response->assertRedirect();
    $feature = Tithe::featureModel()::latest()->first();
    $response->assertRedirectToRoute('features.show', $feature->id);
    expect($feature)
        ->name->toBe($data['name'])
        ->periodicity->toBe($data['periodicity'])
        ->periodicity_type->toBe($data['periodicity_type']);
});

test('update feature page can be rendered', function () {
    $this->actingAs($user = TitheUser::factory()->create(), 'tithe');

    $feature = Tithe::featureModel()::factory()->create();

    $response = $this->get(route('features.edit', $feature->id));

    $response->assertStatus(200);
});

test('feature can be updated', function () {
    $this->actingAs($user = TitheUser::factory()->create(), 'tithe');

    $feature = Tithe::featureModel()::factory()->create();
    $data = Tithe::featureModel()::factory()->raw();

    $response = $this->put(route('features.update', $feature->id), $data);

    $response->assertRedirectToRoute('features.show', $feature->id);
    expect($feature->fresh())
        ->consumable->toBe($data['consumable'])
        ->periodicity->toBe($data['periodicity'])
        ->periodicity_type->toBe($data['periodicity_type'])
        ->quota->toBe($data['quota'])
        ->postpaid->toBe($data['postpaid']);
});

test('feature name can not be updated', function () {
    $this->actingAs($user = TitheUser::factory()->create(), 'tithe');

    $feature = Tithe::featureModel()::factory()->create();
    $data = Tithe::featureModel()::factory()->raw();

    $response = $this->put(route('features.update', $feature->id), array_merge($data, [
        'name' => 'name',
    ]));

    $response->assertRedirectToRoute('features.show', $feature->id);
    expect($feature->fresh())
        ->name->toBe($feature->name);
});

test('feature with plans can not be updated', function () {
    $this->actingAs($user = TitheUser::factory()->create(), 'tithe');

    $feature = Tithe::featureModel()::factory()->hasAttached(
        Tithe::planModel()::factory()->count(3)->create(),
        ['charges' => 20]
    )->create();
    $data = Tithe::featureModel()::factory()->raw();

    $response = $this->put(route('features.update', $feature->id), $data);
    $this->assertEquals(403, $response->status());
});

test('feature can be deleted', function () {
    $this->actingAs($user = TitheUser::factory()->create(), 'tithe');

    $feature = Tithe::featureModel()::factory()->create();

    $response = $this->delete(route('features.destroy', $feature->id));

    $response->assertRedirectToRoute('features.index');
    expect(Tithe::featureModel()::count())->toBe(0);
});
