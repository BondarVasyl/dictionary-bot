<?php

namespace App\Http\Middleware;

use App\Facades\FlashMessages;
use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class AuthGates
{
    public function handle($request, Closure $next)
    {

        $user = \Auth::user();

        if (!app()->runningInConsole() && $user) {
            $roles = Role::with('permissions')->get();

            foreach ($roles as $role) {
                foreach ($role->permissions as $permissions) {
                    $permissionsArray[$permissions->title][] = $role->id;
                }
            }

            if (empty($permissionsArray) == true) {
                FlashMessages::add('success', 'tata');
                Session::flash('message', 'This is a message!');
                Auth::logout();
                return redirect('/admin/login')->with('message', 'Thanks for registering!');
            } else {
                foreach ($permissionsArray as $title => $roles) {
                    Gate::define($title, function (\App\Models\User $user) use ($roles) {
                        return count(array_intersect($user->roles->pluck('id')->toArray(), $roles)) > 0;
                    });
                }
            }
        }

        return $next($request);
    }
}
