<?php

use Tithe\Tests\Mocks;
use Tithe\Tests\TestCase;
use Tithe\Tithe;

uses(TestCase::class)->in(__DIR__);

/**
 * Set default models for testing.
 */
function setTestModels(): void
{
    Tithe::useUserModel(Mocks\TitheUser::class)
        ->usePlanModel(Mocks\Plan::class)
        ->useSubscriptionModel(Mocks\Subscription::class)
        ->useFeatureModel(Mocks\Feature::class)
        ->useFeaturePlanModel(Mocks\FeaturePlan::class)
        ->useFeatureConsumptionModel(Mocks\FeatureConsumption::class)
        ->useSubscriptionRenewalModel(Mocks\SubscriptionRenewal::class)
        ->useSubscriptionInvoiceModel(Mocks\SubscriptionInvoice::class)
        ->useCreditCardModel(Mocks\CreditCard::class)
        ->useCreditCardAuthorizationModel(Mocks\CreditCardAuthorization::class);
}
