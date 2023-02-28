<?php

namespace Tithe\Enums;

use Illuminate\Support\Collection;

enum TitheUserEnum: string
{
    case ADMIN = 'admin';
    case SUPPORT = 'support';

    /**
     * Returns the display name of the active enum.
     *
     * @return string
     */
    public function displayName(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::SUPPORT => 'Support',
        };
    }

    /**
     * To collection.
     *
     * @return \Illuminate\Support\Collection<TKey, TValue>
     */
    public static function toCollection(): Collection
    {
        return collect(self::cases())->mapWithKeys(function (self $role): array {
            return [$role->value => $role->displayName()];
        });
    }

    /**
     * To array.
     *
     * @return array
     */
    public static function toArray(): array
    {
        return self::toCollection()->toArray();
    }
}