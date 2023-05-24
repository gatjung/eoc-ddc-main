<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\DBModelHasRoles;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if (Auth::guard($guard)->check()) {
             // dd(Auth::user()->id);

            // Auth::user()->id;
            $query = DBModelHasRoles::select('role_id')->where('model_id',Auth::user()->id)->first();

            if ($query->role_id == 12 || $query->role_id == 1) {
                return redirect('/hr/ManageUsers');
            } else {
                return redirect('/ddcdrive');
            }
            // return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
