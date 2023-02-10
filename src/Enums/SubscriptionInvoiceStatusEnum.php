<?php

namespace Tithe\Enums;

enum SubscriptionInvoiceStatusEnum: string
{
    case UNPAID = 'unpaid';
    case PAID = 'paid';
    case VOID = 'void';
}
