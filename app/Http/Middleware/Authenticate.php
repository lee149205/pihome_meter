<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Exceptions\ErrorCode;
use App\Exceptions\UnauthorizedException;

class Authenticate extends Middleware
{
    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \App\Exceptions\UnauthorizedException;
     */
    protected function unauthenticated($request, array $guards)
    {
        throw new UnauthorizedException(__('The user credentials were incorrect.'), 0, null, ErrorCode::USER_UNAUTHORIZED);
    }
}
