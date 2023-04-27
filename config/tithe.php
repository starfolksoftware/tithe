<?php

// config for Tithe/Tithe
return [
    'ignores_routes' => false,

    'routes' => [
        'ui' => 'billing',
        'admin' => 'tithe',
    ],

    'ignores_migrations' => false,

    'favicon' => '',

    'app_home_url' => '/app',

    'admin_middlewares' => ['web'],

    'ui_middlewares' => ['auth'],

    'font' => null,

    'logo' => null,

    'color' => null,

    /**
     * Billing address to be displayed on invoices
     */
    'billing_address' => [
        'No 10H Hayatu Road',
        'K/Gayan Lowcost',
        'Zaria, Kaduna',
    ],

    /**
     * Contact information for invoices
     */
    'contact' => [
        'phone' => '',
        'email' => '',
    ],

    /**
     * Styles included here will be included in
     * the billing page, as well as tithe admin
     */
    'styles' => [],

    /**
     * Paystack keys
     */
    'paystack' => [
        'public_key' => null,
        'secret_key' => null,
    ],
];
