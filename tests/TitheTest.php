<?php

use Tithe\Tithe;

beforeAll(function () {
    setTestModels();
});

it('can configure tithe to use USD currency', function () {
    Tithe::currency('USD');

    expect(Tithe::$currency)->toBe('USD');
});

it('can configure tithe subscriber model id to use uuid', function () {
    Tithe::subscriberUsesUuid();

    expect(Tithe::$subscriberUsesUuid)->toBe(true);
});

it('can configure Tithe to support proration by default', function () {
    Tithe::prorates();

    expect(Tithe::$prorates)->toBeTrue();
});

it('con configure Tithe to email invoices to set emails by default', function () {
    Tithe::emailsInvoices();

    expect(Tithe::$emailsInvoices)->toBeTrue();
});
