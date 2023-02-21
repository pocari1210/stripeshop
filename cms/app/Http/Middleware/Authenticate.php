<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
// Routeハザードを読み込む
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{

    // app\Providers\RouteServiceProviderで作成したルート情報を読み込んでいる
    // ⇒各ログイン画面の遷移先をよみこんでいる。

    protected $user_route = 'user.login';
    protected $owner_route = 'owner.login';
    protected $admin_route = 'admin.login';

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */

    // 認証先によってリダイレクト先をif文で記述している
    
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if(Route::is('owner.*')){
                return route($this->owner_route);
            } elseif(Route::is('admin.*')){
                return route($this->admin_route);
            } else {
                return route($this->user_route);
            }
        }
    }
}