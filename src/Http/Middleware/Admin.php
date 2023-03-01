<?php

namespace Tithe\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tithe\Enums\TitheUserRoleEnum;

/**
 * Tithe\Http\Middleware\Admin
 * 
 * @method isOfRole()
 */
class Admin
{
    /**
     * Handle the incoming request.
     *
     * @param $request
     * @param $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $request->user('tithe')->isOfRole(TitheUserRoleEnum::ADMIN->value) ? 
            $next($request) : 
            abort(403);
    }
}