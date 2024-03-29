<?php

namespace Tithe\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ExpiringWithGraceDaysScope implements Scope
{
    protected $extensions = [
        'OnlyExpired',
        'WithExpired',
        'WithoutExpired',
    ];

    public function apply(Builder $builder, Model $model): void
    {
        $builder->where(
            fn (Builder $query) => $query
                ->where('expired_at', '>', now())
                ->orWhere('grace_days_ended_at', '>', now())
        );
    }

    public function extend(Builder $builder): void
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    protected function addWithExpired(Builder $builder): void
    {
        $builder->macro('withExpired', function (Builder $builder, $withExpired = true) {
            if ($withExpired) {
                return $builder->withoutGlobalScope($this);
            }

            return $builder->withoutExpired();
        });
    }

    protected function addWithoutExpired(Builder $builder): void
    {
        $builder->macro('withoutExpired', function (Builder $builder) {
            $builder->withoutGlobalScope($this)->where('expired_at', '>', now())
                ->orWhere('grace_days_ended_at', '>', now());

            return $builder;
        });
    }

    protected function addOnlyExpired(Builder $builder): void
    {
        $builder->macro('onlyExpired', function (Builder $builder) {
            $builder->withoutGlobalScope($this)
                ->where('expired_at', '<=', now())
                ->where(
                    fn (Builder $query) => $query->where('grace_days_ended_at', '<=', now())
                        ->orWhereNull('grace_days_ended_at')
                );

            return $builder;
        });
    }
}
