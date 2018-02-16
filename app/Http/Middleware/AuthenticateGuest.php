<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;

class AuthenticateGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->guest()) {
            Auth::login($user = factory(User::class)->make([
                'id' => (int) str_replace('.', '', microtime(true)),
                'username' => 'guest',
                'name' => 'guest',
                'confirmed' => false
            ]));
        }

        return $next($request);
    }
}
