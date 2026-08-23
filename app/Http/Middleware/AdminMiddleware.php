<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{

    public function handle($request, Closure $next, $guard = null)
    {
        // Получаем название права
        if(isset($request->route()->getController()->crud->entity_name)){
            $entity_name = $request->route()->getController()->crud->entity_name;
            $entity_name = strtolower($entity_name);
        }

        if(!Auth::guard($guard)->check()) return redirect('/admin');

        if( request('debug') ) {
            dd(Auth::user()->can($entity_name));
            dd($entity_name);
        }

        if (!isset($entity_name) || Auth::user()->can($entity_name) || $request->route()->getController()->crud->entity_name == 'export') {
            return $next($request);
        }else{
            return response('You do not have access', 403);
        }
    }

}
