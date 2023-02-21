<?php

// namespaceをOwner\Authに変更
namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        // 三項演算子を用いて、
        // trueならADMIN_HOMEにリダイレクト
        // falseならresources\views\auth\verify-email.blade.phpを開く        
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(RouteServiceProvider::ADMIN_HOME)
                    : view('admin.auth.verify-email');
    }
}