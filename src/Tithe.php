<?php

namespace Tithe;

use Tithe\Contracts\AttachesFeaturesToPlans;
use Tithe\Contracts\CreatesAuthorizations;
use Tithe\Contracts\CreatesFeatures;
use Tithe\Contracts\CreatesPlans;
use Tithe\Contracts\DetachesFeaturesFromPlans;
use Tithe\Contracts\UpdatesFeatures;
use Tithe\Contracts\UpdatesPlans;

final class Tithe
{
    /**
     * Indicates the default currency.
     *
     * @var string
     */
    public static $currency = 'NGN';

    /**
     * Indicates if a subscriber id is a uuid.
     *
     * @var bool
     */
    public static $subscriberUsesUuid = false;

    /**
     * Indicates whether Tithe prorates especially when upgrading to higher plans.
     *
     * @var bool
     */
    public static $prorates = true;

    /**
     * Indicates whether created invoices are automatically sent to set emails.
     *
     * @var bool
     */
    public static $emailsInvoices = true;

    /**
     * The default admin routes prefix.
     *
     * @var string
     */
    public static $adminRoutesPrefix = 'tithe';

    /**
     * The default ui routes prefix.
     *
     * @var string
     */
    public static $uiRoutesPrefix = 'billing';

    /**
     * The user model table name.
     *
     * @var string
     */
    public static $userTableName = 'tithe_users';

    /**
     * The user model that should be used by Tithe.
     *
     * @var string
     */
    public static $userModel = 'App\\Models\\TitheUser';

    /**
     * The plan model table name.
     *
     * @var string
     */
    public static $planTableName = 'plans';

    /**
     * The plan model that should be used by Tithe.
     *
     * @var string
     */
    public static $planModel = 'App\\Models\\Plan';

    /**
     * The subscription model table name.
     *
     * @var string
     */
    public static $subscriptionTableName = 'subscriptions';

    /**
     * The subscripton model that should be used by Tithe.
     *
     * @var string
     */
    public static $subscriptionModel = 'App\\Models\\Subscription';

    /**
     * The feature model table name.
     *
     * @var string
     */
    public static $featureTableName = 'features';

    /**
     * The feature model that should be used by Tithe.
     *
     * @var string
     */
    public static $featureModel = 'App\\Models\\Feature';

    /**
     * The feature plan pivot model table name.
     *
     * @var string
     */
    public static $featurePlanTableName = 'feature_plan';

    /**
     * The feature plan pivot model that should be used by Tithe.
     *
     * @var string
     */
    public static $featurePlanModel = 'App\\Models\\FeaturePlan';

    /**
     * The feature consumption model table name.
     *
     * @var string
     */
    public static $featureConsumptionTableName = 'feature_consumptions';

    /**
     * The feature consumption model that should be used by Tithe.
     *
     * @var string
     */
    public static $featureConsumptionModel = 'App\\Models\\FeatureConsumption';

    /**
     * The subscription renewal model table name.
     *
     * @var string
     */
    public static $subscriptionRenewalTableName = 'subscription_renewals';

    /**
     * The subscripton model that should be used by Tithe.
     *
     * @var string
     */
    public static $subscriptionRenewalModel = 'App\\Models\\SubscriptionRenewal';

    /**
     * The subscription invoice model table name.
     *
     * @var string
     */
    public static $subscriptionInvoiceTableName = 'subscription_invoices';

    /**
     * The subscription invoice model that should be used by Tithe.
     *
     * @var string
     */
    public static $subscriptionInvoiceModel = 'App\\Models\\SubscriptionInvoice';

    /**
     * The subscription invoice payment model table name.
     *
     * @var string
     */
    public static $subscriptionInvoicePaymentTableName = 'subscription_invoice_payments';

    /**
     * The credit card model table name.
     *
     * @var string
     */
    public static $creditCardTableName = 'credit_cards';

    /**
     * The credit card model that should be used by Tithe.
     *
     * @var string
     */
    public static $creditCardModel = 'App\\Models\\CreditCard';

    /**
     * The credit card authorizations model table name.
     *
     * @var string
     */
    public static $creditCardAuthorizationTableName = 'credit_card_authorizations';

    /**
     * The credit card authorizations model that should be used by Tithe.
     *
     * @var string
     */
    public static $creditCardAuthorizationModel = 'App\\Models\\CreditCardAuthorization';

    /**
     * The callback that is responsible for getting the active subscriber.
     *
     * @var callable|null
     */
    public static $activeSubscriberCallback;

    /**
     * Configure Tithe to use the provided currency.
     *
     * @return static
     */
    public static function currency(string $currency)
    {
        self::$currency = $currency;

        return new self();
    }

    /**
     * Configure Tithe subscriber model to use uuid.
     *
     * @param  bool  $value
     * @return static
     */
    public static function subscriberUsesUuid($value = true)
    {
        self::$subscriberUsesUuid = $value;

        return new self();
    }

    /**
     * Configure Tithe to support proration.
     *
     * @return static
     */
    public static function prorates(bool $value = true)
    {
        self::$prorates = $value;

        return new self();
    }

    /**
     * Configure Tithe to indicate if invoices are sent to set emails.
     *
     * @return static
     */
    public static function emailsInvoices(bool $value = true)
    {
        self::$emailsInvoices = $value;

        return new self();
    }

    /**
     * Sets the default ui routes prefix.
     *
     * @return static
     */
    public static function defaultUiRoutesPrefix(string $prefix)
    {
        self::$uiRoutesPrefix = $prefix;

        return new self();
    }

    /**
     * Returns the default admin routes prefix.
     */
    public static function adminRoutesPrefix(): string
    {
        return self::$adminRoutesPrefix;
    }

    /**
     * Returns the default ui routes prefix.
     */
    public static function uiRoutesPrefix(): string
    {
        return self::$uiRoutesPrefix;
    }

    /**
     * Sets the subscription model's table name.
     *
     * @return static
     */
    public static function subscriptionTableName(string $name)
    {
        self::$subscriptionTableName = $name;

        return new self();
    }

    /**
     * Get the name of the user model used by the application.
     *
     * @return string
     */
    public static function userModel()
    {
        return self::$userModel;
    }

    /**
     * Specify the user model that should be used by Tithe.
     *
     * @return static
     */
    public static function useUserModel(string $model)
    {
        self::$userModel = $model;

        return new self();
    }

    /**
     * Get a new instance of the user model.
     *
     * @return mixed
     */
    public static function newUserModel()
    {
        $model = self::userModel();

        return new $model();
    }

    /**
     * Get the name of the plan model used by the application.
     *
     * @return string
     */
    public static function planModel()
    {
        return self::$planModel;
    }

    /**
     * Specify the plan model that should be used by Tithe.
     *
     * @return static
     */
    public static function usePlanModel(string $model)
    {
        self::$planModel = $model;

        return new self();
    }

    /**
     * Get a new instance of the plan model.
     *
     * @return mixed
     */
    public static function newPlanModel()
    {
        $model = self::planModel();

        return new $model();
    }

    /**
     * Get the name of the subscription model used by the application.
     *
     * @return string
     */
    public static function subscriptionModel()
    {
        return self::$subscriptionModel;
    }

    /**
     * Specify the subscription model that should be used by Tithe.
     *
     * @return static
     */
    public static function useSubscriptionModel(string $model)
    {
        self::$subscriptionModel = $model;

        return new self();
    }

    /**
     * Get a new instance of the subscription model.
     *
     * @return mixed
     */
    public static function newSubscriptionModel()
    {
        $model = self::subscriptionModel();

        return new $model();
    }

    /**
     * Get the name of the feature model used by the application.
     *
     * @return string
     */
    public static function featureModel()
    {
        return self::$featureModel;
    }

    /**
     * Specify the feature model that should be used by Tithe.
     *
     * @return static
     */
    public static function useFeatureModel(string $model)
    {
        self::$featureModel = $model;

        return new self();
    }

    /**
     * Get a new instance of the feature model.
     *
     * @return mixed
     */
    public static function newFeatureModel()
    {
        $model = self::featureModel();

        return new $model();
    }

    /**
     * Get the name of the feature plan pivot model used by the application.
     *
     * @return string
     */
    public static function featurePlanModel()
    {
        return self::$featurePlanModel;
    }

    /**
     * Specify the feature plan pivot model that should be used by Tithe.
     *
     * @return static
     */
    public static function useFeaturePlanModel(string $model)
    {
        self::$featurePlanModel = $model;

        return new self();
    }

    /**
     * Get a new instance of the feature plan pivot model.
     *
     * @return mixed
     */
    public static function newFeaturePlanModel()
    {
        $model = self::featurePlanModel();

        return new $model();
    }

    /**
     * Get the name of the feature consumption model used by the application.
     *
     * @return string
     */
    public static function featureConsumptionModel()
    {
        return self::$featureConsumptionModel;
    }

    /**
     * Specify the feature consumption model that should be used by Tithe.
     *
     * @return static
     */
    public static function useFeatureConsumptionModel(string $model)
    {
        self::$featureConsumptionModel = $model;

        return new self();
    }

    /**
     * Get a new instance of the feature consumption model.
     *
     * @return mixed
     */
    public static function newFeatureConsumptionModel()
    {
        $model = self::featureConsumptionModel();

        return new $model();
    }

    /**
     * Get the name of the subscription renewal model used by the application.
     *
     * @return string
     */
    public static function subscriptionRenewalModel()
    {
        return self::$subscriptionRenewalModel;
    }

    /**
     * Specify the subscription renewal model that should be used by Tithe.
     *
     * @return static
     */
    public static function useSubscriptionRenewalModel(string $model)
    {
        self::$subscriptionRenewalModel = $model;

        return new self();
    }

    /**
     * Get a new instance of the subscription renewal model.
     *
     * @return mixed
     */
    public static function newSubscriptionRenewalModel()
    {
        $model = self::subscriptionRenewalModel();

        return new $model();
    }

    /**
     * Get the name of the subscription invoice model used by the application.
     *
     * @return string
     */
    public static function subscriptionInvoiceModel()
    {
        return self::$subscriptionInvoiceModel;
    }

    /**
     * Specify the subscription invoice model that should be used by Tithe.
     *
     * @return static
     */
    public static function useSubscriptionInvoiceModel(string $model)
    {
        self::$subscriptionInvoiceModel = $model;

        return new self();
    }

    /**
     * Get a new instance of the subscription invoice model.
     *
     * @return mixed
     */
    public static function newSubscriptionInvoiceModel()
    {
        $model = self::subscriptionInvoiceModel();

        return new $model();
    }

    /**
     * Get the name of the credit card model used by the application.
     *
     * @return string
     */
    public static function creditCardModel()
    {
        return self::$creditCardModel;
    }

    /**
     * Specify the credit card model that should be used by Tithe.
     *
     * @return static
     */
    public static function useCreditCardModel(string $model)
    {
        self::$creditCardModel = $model;

        return new self();
    }

    /**
     * Get a new instance of the credit card model.
     *
     * @return mixed
     */
    public static function newCreditCardModel()
    {
        $model = self::creditCardModel();

        return new $model();
    }

    /**
     * Get the name of the credit card authorization model used by the application.
     *
     * @return string
     */
    public static function creditCardAuthorizationModel()
    {
        return self::$creditCardAuthorizationModel;
    }

    /**
     * Specify the credit card authorization model that should be used by Tithe.
     *
     * @return static
     */
    public static function useCreditCardAuthorizationModel(string $model)
    {
        self::$creditCardAuthorizationModel = $model;

        return new self();
    }

    /**
     * Get a new instance of the credit card authorization model.
     *
     * @return mixed
     */
    public static function newCreditCardAuthorizationModel()
    {
        $model = self::creditCardAuthorizationModel();

        return new $model();
    }

    /**
     * Generate a Gravatar for a given email.
     */
    public static function gravatar(
        string $email,
        int $size = 200,
        string $default = 'retro',
        string $rating = 'g'
    ): string {
        $hash = md5(trim(\Illuminate\Support\Str::lower($email)));

        return "https://secure.gravatar.com/avatar/{$hash}?s={$size}&d={$default}&r={$rating}";
    }

    /**
     * Register a class / callback that should be used to create plans.
     *
     * @return void
     */
    public static function createPlansUsing(string $class)
    {
        app()->singleton(CreatesPlans::class, $class);
    }

    /**
     * Register a class / callback that should be used to update plans.
     *
     * @return void
     */
    public static function updatePlansUsing(string $class)
    {
        app()->singleton(UpdatesPlans::class, $class);
    }

    /**
     * Register a class / callback that should be used to create features.
     *
     * @return void
     */
    public static function createFeaturesUsing(string $class)
    {
        app()->singleton(CreatesFeatures::class, $class);
    }

    /**
     * Register a class / callback that should be used to update features.
     *
     * @return void
     */
    public static function updateFeaturesUsing(string $class)
    {
        app()->singleton(UpdatesFeatures::class, $class);
    }

    /**
     * Register a class / callback that should be used to attach features to plans.
     *
     * @return void
     */
    public static function attachFeaturesToPlansUsing(string $class)
    {
        app()->singleton(AttachesFeaturesToPlans::class, $class);
    }

    /**
     * Register a class / callback that should be used to detach features from plans.
     *
     * @return void
     */
    public static function detachFeaturesFromPlansUsing(string $class)
    {
        app()->singleton(DetachesFeaturesFromPlans::class, $class);
    }

    /**
     * Register a class / callback that should be used to create card authorizations.
     *
     * @return void
     */
    public static function createAuthorizationsUsing(string $class)
    {
        app()->singleton(CreatesAuthorizations::class, $class);
    }

    /**
     * Register a callback that is responsible for getting the currently active subscriber.
     *
     * @return static
     */
    public static function getActiveSubscriberUsing(callable $callback)
    {
        self::$activeSubscriberCallback = $callback;

        return new self();
    }
}
