<?php

namespace Tithe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Tithe\Enums\SubscriptionInvoiceStatusEnum;

abstract class SubscriptionInvoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'line_items',
        'total',
        'due_date',
        'status',
        'paid_at',
        'meta'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'line_items' => 'array',
        'total' => 'int',
        'due_date' => 'datetime',
        'paid_at' => 'datetime',
        'meta' => 'array',
    ];

    /**
     * Returns the model's table name
     * 
     * @return string
     */
    public function getTable()
    {
        return Tithe::$subscriptionInvoiceTableName;
    }

    /**
     * Get the subscription of the invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription()
    {
        return $this->belongsTo(Tithe::subscriptionModel());
    }

    /**
     * Get the payments of the authorization
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(Tithe::subscriptionPaymentModel());
    }

    /**
     * Filter query by paid.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopePaid($query)
    {
        $query->where('status', SubscriptionInvoiceStatusEnum::PAID->value);
    }

    /**
     * Filter query by unpaid.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeUnpaid($query)
    {
        $query->where('status', SubscriptionInvoiceStatusEnum::UNPAID->value);
    }

    /**
     * Filter query by void.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeVoid($query)
    {
        $query->where('status', SubscriptionInvoiceStatusEnum::VOID->value);
    }

    /**
     * Filter query by void or not paid.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeVoidOrUnpaid($query)
    {
        $query->where('status', SubscriptionInvoiceStatusEnum::VOID->value)
            ->orWhere('status', SubscriptionInvoiceStatusEnum::UNPAID->value);
    }

    /**
     * Filter query by past due.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopePastDue($query)
    {
        $query->whereNotNull('due_date')->where('due_date', '>', Carbon::now());
    }

    /**
     * mark invoice as void.
     *
     * @return $this
     */
    public function void()
    {
        $this->status = SubscriptionInvoiceStatusEnum::VOID->value;
        $this->save();

        return $this;
    }

    /**
     * mark invoice as paid.
     *
     * @return $this
     */
    public function markPaid()
    {
        $this->status = SubscriptionInvoiceStatusEnum::PAID->value;
        $this->paid_at = now();
        $this->save();

        return $this;
    }

    /**
     * mark invoice as unpaid.
     *
     * @return $this
     */
    public function markUnpaid()
    {
        $this->status = SubscriptionInvoiceStatusEnum::UNPAID->value;
        $this->paid_at = null;
        $this->save();

        return $this;
    }

    /**
     * Get the Subscriber model instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function owner()
    {
        return $this->subscription->subscriber;
    }
}
