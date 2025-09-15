<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class Role
{
    public function handle($request, Closure $next, $role, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }
        dd($role);
//dd(Auth::guard($guard)->user());
$role=Auth::guard($guard)->user()->menuroles;
        $roles = is_array($role)
            ? $role
            : explode(',', $role);
            //dd( $roles);
        //dd($roles);
        if (! Auth::guard($guard)->user()->hasAnyRole($roles)) {
            throw UnauthorizedException::forRoles($roles);
       }

        return $next($request);
    }
}
