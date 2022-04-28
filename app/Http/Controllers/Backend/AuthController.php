<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\MessageBag;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $email = $request->email;

        $user = User::where('email', $email)->with('roles')->first();

        if (!$user) {
            $errors = new MessageBag(['email' => ['These credentials do not match our records.']]);

            return Redirect::back()->withErrors($errors);
        }

        $flag = false;

        foreach ($user->roles as $role) {
            if ($role->title != 'User') {
                $flag = true;
            }
        }
        if (!$flag) {
            return abort(403);
        } else {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect('/admin');
            }

            $errors = new MessageBag(['email' => ['These credentials do not match our records.']]);

            return Redirect::back()->withErrors($errors);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/admin/login');
    }
}
