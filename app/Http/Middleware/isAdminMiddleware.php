<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class isAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $openRoutes = [
        'AdminPanel/auth/*',
    ];
    public function handle($request, Closure $next)
    {
        if(!in_array($request->path(), $this->openRoutes)){
            // dd($request);
            if ($request->user() != null) {
                
                    $locale = $request->user()->language;
                    if ($locale !== null && in_array($locale, config('app.locales'))) {
                        App::setLocale($locale);
                    }
            
                    if ($locale === null) {
                        $request->session()->put('Lang',config('app.locale'));
                    }
            
                    return $next($request);
                
            }
        }
        return redirect()->route('admin.login');
    }
}
