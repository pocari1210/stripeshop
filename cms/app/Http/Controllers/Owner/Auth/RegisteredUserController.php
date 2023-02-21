<?php

// namespaceをOwner\Authに変更
namespace App\Http\Controllers\Owner\Auth;

use App\Http\Controllers\Controller;

// Ownerモデルを読み込む
use App\Models\Owner;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // view内をowner.auth.registerにする
        return view('owner.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // emailをownerに変更
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:owners',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Auth::guard('owners')とし、guard設定をする
        Auth::guard('owners')->login($user = Owner::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]));

        event(new Registered($user));

        // リダイレクト先をOWNER_HOMEとする
        return redirect(RouteServiceProvider::OWNER_HOME);
    }
}