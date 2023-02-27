<?php

namespace Tithe;

use Tithe\Scopes\ExpiringScope;

/**
 * Tithe\Expires
 *
 * @property mixed $expired_at
 */
trait Expires
{
    public static function bootExpires()
    {
        static::addGlobalScope(new ExpiringScope());
    }

    public function initializeExpires()
    {
        if (! isset($this->casts['expired_at'])) {
            $this->casts['expired_at'] = 'datetime';
        }
    }

    public function expired()
    {
        return $this->expired_at->isPast();
    }

    public function notExpired()
    {
        return ! $this->expired();
    }
}
