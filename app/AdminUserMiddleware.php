<?php

namespace App;

use Closure;

class AdminUserMiddleware
{

    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if (!User::isAdmin()) {
            return redirect()->to('/');
        }

        return $next($request);
    }


}
