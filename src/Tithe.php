<?php

namespace Tithe;

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
     * Indicates whether Tithe soft deletes recurrences.
     *
     * @var bool
     */
    public static $supportsSoftDeletes = true;

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
     * @param  string  $currency
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
     * Configure Tithe to support soft delete.
     *
     * @param  bool  $value
     * @return static
     */
    public static function supportsSoftDeletes(bool $value = true)
    {
        static::$supportsSoftDeletes = $value;

        return new static();
    }

    /**
     * Configure Tithe to support proration.
     *
     * @param  bool  $value
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
     * @param  bool  $value
     * @return static
     */
    public static function emailsInvoices(bool $value = true)
    {
        static::$emailsInvoices = $value;

        return new static();
    }

    /**
     * Sets the subscription model's table name.
     *
     * @param  string  $name
     * @return static
     */
    public static function subscriptionTableName(string $name)
    {
        static::$subscriptionTableName = $name;

        return new static();
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
     * @param  string  $model
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
     * @param  string  $model
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
     * @param  string  $model
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
     * @param  string  $model
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
     * @param  string  $model
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
}
