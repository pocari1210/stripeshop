<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{

    // ※config\auth.phpの「Authentication Guards」の箇所を読み込んでいる
    // ※このクラスでしかつかわないため、privateを定数にする
    private const GUARD_USER = 'users';
    private const GUARD_OWNER = 'owners';
    private const GUARD_ADMIN = 'admin';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {

        // $guards = empty($guards) ? [null] : $guards;

        // Auth::guardでチェックをかけて、ログインしていたら
        // RouteServiceProvider::HOMEにリダイレクトされる
        // ※使用しないため、コメントアウト

        // foreach ($guards as $guard) {
        //     if (Auth::guard($guard)->check()) {
        //         return redirect(RouteServiceProvider::HOME);
        //     }
        // }

        // ★userとして認証しているかチェックをし、HOMEにリダイレクトさせる★
        if(Auth::guard(self::GUARD_USER)->check() && $request->routeIs('user.*')){
            return redirect(RouteServiceProvider::HOME);
        }

        // ★ownerとして認証しているかチェックをし、OWNER_HOMEにリダイレクトさせる★
        if(Auth::guard(self::GUARD_OWNER)->check() && $request->routeIs('owner.*')){
            return redirect(RouteServiceProvider::OWNER_HOME);
        }

        // ★adminとして認証しているかチェックをし、ADMIN_HOMEにリダイレクトさせる★
        if(Auth::guard(self::GUARD_ADMIN)->check() && $request->routeIs('admin.*')){
            return redirect(RouteServiceProvider::ADMIN_HOME);
        }

        return $next($request);
    }
}