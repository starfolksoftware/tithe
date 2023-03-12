<?php

namespace Tithe;

use Tithe\Contracts\CreatesFeatures;
use Tithe\Contracts\CreatesPlans;
use Tithe\Contracts\UpdatesFeatures;
use Tithe\Contracts\UpdatesPlans;

final class Tithe
{
    /**
     * Indicates if Tithe migrations should be ran.
     *
     * @var bool
     */
    public static $runsMigrations = true;

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
     * Indicates whether the package supports tickets.
     *
     * @var bool
     */
    public static $supportsFeatureTicketing = false;

    /**
     * The default middlewares.
     *
     * @var array
     */
    public static $middlewares = ['web'];

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
     * The feature model table name.
     *
     * @var string
     */
    public static $featureTicketTableName = 'feature_tickets';

    /**
     * The feature model that should be used by Tithe.
     *
     * @var string
     */
    public static $featureTicketModel = 'App\\Models\\FeatureTicket';

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
     * Configure Tithe to not run its migrations.
     *
     * @return static
     */
    public static function ignoreMigrations()
    {
        static::$runsMigrations = false;

        return new static();
    }

    /**
     * Configure Tithe to use the provided currency.
     *
     * @return static
     */
    public static function currency(string $currency)
    {
        static::$currency = $currency;

        return new static();
    }

    /**
     * Configure Tithe subscriber model to use uuid.
     *
     * @param  bool  $value
     * @return static
     */
    public static function subscriberUsesUuid($value = true)
    {
        static::$subscriberUsesUuid = $value;

        return new static();
    }

    /**
     * Configure Tithe to support proration.
     *
     * @return static
     */
    public static function prorates(bool $value = true)
    {
        static::$prorates = $value;

        return new static();
    }

    /**
     * Configure Tithe to indicate if invoices are sent to set emails.
     *
     * @return static
     */
    public static function emailsInvoices(bool $value = true)
    {
        static::$emailsInvoices = $value;

        return new static();
    }

    /**
     * Sets the default middlewares.
     *
     * @return static
     */
    public static function defaultMiddlewares(array $middlewares)
    {
        static::$middlewares = $middlewares;

        return new static();
    }

    /**
     * Returns the default middlewares.
     *
     * @return array
     */
    public static function middlewares()
    {
        return static::$middlewares;
    }

    /**
     * Configure Tithe to indicate if feature tickets are supported.
     *
     * @return static
     */
    public static function supportsFeatureTicketing(bool $value = true)
    {
        static::$supportsFeatureTicketing = $value;

        return new static();
    }

    /**
     * Sets the subscription model's table name.
     *
     * @return static
     */
    public static function subscriptionTableName(string $name)
    {
        static::$subscriptionTableName = $name;

        return new static();
    }

    /**
     * Get the name of the user model used by the application.
     *
     * @return string
     */
    public static function userModel()
    {
        return static::$userModel;
    }

    /**
     * Specify the user model that should be used by Tithe.
     *
     * @return static
     */
    public static function useUserModel(string $model)
    {
        static::$userModel = $model;

        return new static();
    }

    /**
     * Get a new instance of the user model.
     *
     * @return mixed
     */
    public static function newUserModel()
    {
        $model = static::userModel();

        return new $model();
    }

    /**
     * Get the name of the plan model used by the application.
     *
     * @return string
     */
    public static function planModel()
    {
        return static::$planModel;
    }

    /**
     * Specify the plan model that should be used by Tithe.
     *
     * @return static
     */
    public static function usePlanModel(string $model)
    {
        static::$planModel = $model;

        return new static();
    }

    /**
     * Get a new instance of the plan model.
     *
     * @return mixed
     */
    public static function newPlanModel()
    {
        $model = static::planModel();

        return new $model();
    }

    /**
     * Get the name of the subscription model used by the application.
     *
     * @return string
     */
    public static function subscriptionModel()
    {
        return static::$subscriptionModel;
    }

    /**
     * Specify the subscription model that should be used by Tithe.
     *
     * @return static
     */
    public static function useSubscriptionModel(string $model)
    {
        static::$subscriptionModel = $model;

        return new static();
    }

    /**
     * Get a new instance of the subscription model.
     *
     * @return mixed
     */
    public static function newSubscriptionModel()
    {
        $model = static::subscriptionModel();

        return new $model();
    }

    /**
     * Get the name of the feature model used by the application.
     *
     * @return string
     */
    public static function featureModel()
    {
        return static::$featureModel;
    }

    /**
     * Specify the feature model that should be used by Tithe.
     *
     * @return static
     */
    public static function useFeatureModel(string $model)
    {
        static::$featureModel = $model;

        return new static();
    }

    /**
     * Get a new instance of the feature model.
     *
     * @return mixed
     */
    public static function newFeatureModel()
    {
        $model = static::featureModel();

        return new $model();
    }

    /**
     * Get the name of the feature ticket model used by the application.
     *
     * @return string
     */
    public static function featureTicketModel()
    {
        return static::$featureTicketModel;
    }

    /**
     * Specify the feature ticket model that should be used by Tithe.
     *
     * @return static
     */
    public static function useFeatureTicketModel(string $model)
    {
        static::$featureTicketModel = $model;

        return new static();
    }

    /**
     * Get a new instance of the feature ticket model.
     *
     * @return mixed
     */
    public static function newFeatureTicketModel()
    {
        $model = static::featureTicketModel();

        return new $model();
    }

    /**
     * Get the name of the feature plan pivot model used by the application.
     *
     * @return string
     */
    public static function featurePlanModel()
    {
        return static::$featurePlanModel;
    }

    /**
     * Specify the feature plan pivot model that should be used by Tithe.
     *
     * @return static
     */
    public static function useFeaturePlanModel(string $model)
    {
        static::$featurePlanModel = $model;

        return new static();
    }

    /**
     * Get a new instance of the feature plan pivot model.
     *
     * @return mixed
     */
    public static function newFeaturePlanModel()
    {
        $model = static::featurePlanModel();

        return new $model();
    }

    /**
     * Get the name of the feature consumption model used by the application.
     *
     * @return string
     */
    public static function featureConsumptionModel()
    {
        return static::$featureConsumptionModel;
    }

    /**
     * Specify the feature consumption model that should be used by Tithe.
     *
     * @return static
     */
    public static function useFeatureConsumptionModel(string $model)
    {
        static::$featureConsumptionModel = $model;

        return new static();
    }

    /**
     * Get a new instance of the feature consumption model.
     *
     * @return mixed
     */
    public static function newFeatureConsumptionModel()
    {
        $model = static::featureConsumptionModel();

        return new $model();
    }

    /**
     * Get the name of the subscription renewal model used by the application.
     *
     * @return string
     */
    public static function subscriptionRenewalModel()
    {
        return static::$subscriptionRenewalModel;
    }

    /**
     * Specify the subscription renewal model that should be used by Tithe.
     *
     * @return static
     */
    public static function useSubscriptionRenewalModel(string $model)
    {
        static::$subscriptionRenewalModel = $model;

        return new static();
    }

    /**
     * Get a new instance of the subscription renewal model.
     *
     * @return mixed
     */
    public static function newSubscriptionRenewalModel()
    {
        $model = static::subscriptionRenewalModel();

        return new $model();
    }

    /**
     * Get the name of the subscription invoice model used by the application.
     *
     * @return string
     */
    public static function subscriptionInvoiceModel()
    {
        return static::$subscriptionInvoiceModel;
    }

    /**
     * Specify the subscription invoice model that should be used by Tithe.
     *
     * @return static
     */
    public static function useSubscriptionInvoiceModel(string $model)
    {
        static::$subscriptionInvoiceModel = $model;

        return new static();
    }

    /**
     * Get a new instance of the subscription invoice model.
     *
     * @return mixed
     */
    public static function newSubscriptionInvoiceModel()
    {
        $model = static::subscriptionInvoiceModel();

        return new $model();
    }

    /**
     * Get the name of the credit card model used by the application.
     *
     * @return string
     */
    public static function creditCardModel()
    {
        return static::$creditCardModel;
    }

    /**
     * Specify the credit card model that should be used by Tithe.
     *
     * @return static
     */
    public static function useCreditCardModel(string $model)
    {
        static::$creditCardModel = $model;

        return new static();
    }

    /**
     * Get a new instance of the credit card model.
     *
     * @return mixed
     */
    public static function newCreditCardModel()
    {
        $model = static::creditCardModel();

        return new $model();
    }

    /**
     * Get the name of the credit card authorization model used by the application.
     *
     * @return string
     */
    public static function creditCardAuthorizationModel()
    {
        return static::$creditCardAuthorizationModel;
    }

    /**
     * Specify the credit card authorization model that should be used by Tithe.
     *
     * @return static
     */
    public static function useCreditCardAuthorizationModel(string $model)
    {
        static::$creditCardAuthorizationModel = $model;

        return new static();
    }

    /**
     * Get a new instance of the credit card authorization model.
     *
     * @return mixed
     */
    public static function newCreditCardAuthorizationModel()
    {
        $model = static::creditCardAuthorizationModel();

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
}
