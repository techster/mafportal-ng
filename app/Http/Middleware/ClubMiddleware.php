<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Club;

class ClubMiddleware
{

    public function handle($request, Closure $next, $guard = null)
    {
        $club = Club::findBySlug($request->route('slug'));
        if (!$club) {
            abort(404, 'Please go back to our <a href="' . url('') . '">homepage</a>.');
        }

        if(
            Auth::user()
            and (Auth::user()->clubs->contains($club->id) or Auth::user()->hasAnyRole(['Technical Admin','Portal Admin']))
            or !$club->private
        ){
            return $next($request);
        }else{
            $request->attributes->add(['error' => trans('clubs.access')]);
            return $next($request);
        }
    }

}
