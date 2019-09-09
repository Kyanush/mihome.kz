<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use Auth;

class OwnerMiddleware
{

    public function handle($request, Closure $next, ... $role){

        if($role)
            if(Auth::check())
                if (!$request->user()->hasRole($role)) {
                    return request()->ajax() ? response()->json('У вас нет прав!', 403) : Redirect::back();
                }


        return $next($request);
    }

}
