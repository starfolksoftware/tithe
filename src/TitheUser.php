<?php

namespace Tithe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tithe\Enums\TitheUserRoleEnum;

/**
 * Tithe\TitheUser
 * 
 * @property mixed $role
 */
abstract class TitheUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'avatar',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string,string>
     */
    protected $casts = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'default_avatar',
    ];

    /**
     * Gets database name of the model.
     */
    public function getTable(): string
    {
        return 'tithe_users';
    }

    /**
     * Checks if the user is of the provided role.
     * 
     * @param string $role
     * @return bool
     * @throws \Exception
     */
    public function isOfRole(string $role): bool
    {
        if (! in_array($role, TitheUserRoleEnum::toCollection()->keys()->toArray())) {
            throw new \Exception("Invalid role");
        }

        return $this->role === $role;
    }

    /**
     * Return a default user avatar.
     *
     * @return string
     */
    public function getDefaultAvatarAttribute(): string
    {
        return Tithe::gravatar($this->email ?? '');
    }
}
