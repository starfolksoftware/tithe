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
    public static $supportsSoftDeletes = false;

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
     * @param string $currency
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
     * @param bool $value
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
}
