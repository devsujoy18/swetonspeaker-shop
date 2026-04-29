<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SiteSetting;

class EnsureCartEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $setting = SiteSetting::getSettings();

        if (!$setting->cart_enabled) {
            return redirect()
                ->route('cart')
                ->with('error', $setting->cart_disabled_message ?? 'Cart is disabled');
        }
        
        return $next($request);
    }
}
