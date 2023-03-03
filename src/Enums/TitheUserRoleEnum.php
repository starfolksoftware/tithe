<?php

namespace Tithe\Enums;

use Illuminate\Support\Collection;

enum TitheUserRoleEnum: string
{
    case ADMIN = 'admin';

    /**
     * Returns the display name of the active enum.
     */
    public function displayName(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
        };
    }

    /**
     * To collection.
     */
    public static function toCollection(): Collection
    {
        return collect(self::cases())->mapWithKeys(function (self $role): array {
            return [$role->value => $role->displayName()];
        });
    }

    /**
     * To array.
     */
    public static function toArray(): array
    {
        return self::toCollection()->toArray();
    }
}
