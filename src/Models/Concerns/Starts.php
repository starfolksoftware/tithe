<?php

namespace Tithe\Models\Concerns;

use Tithe\Models\Scopes\StartingScope;

trait Starts
{
    public static function bootStarts()
    {
        static::addGlobalScope(new StartingScope());
    }

    public function initializeStarts()
    {
        if (! isset($this->casts['started_at'])) {
            $this->casts['started_at'] = 'datetime';
        }
    }

    public function started()
    {
        if (empty($this->started_at)) {
            return false;
        }

        return $this->started_at->isPast();
    }

    public function notStarted()
    {
        return ! $this->started();
    }
}
