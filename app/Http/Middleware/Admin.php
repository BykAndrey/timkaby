<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

use Illuminate\Support\Facades\Auth;
class Admin
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
        $id=intval(Auth::id());
        $user=User::find($id);// dd(session()->all());
        if($user!=null)
            if($user->id_role==1){
                return $next($request);
            }
        //dd(session()->all());
        return redirect(route('home'));

    }
}
