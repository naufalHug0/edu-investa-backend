<?php

namespace App\Http\Middleware;

use App\Helpers\Api;
use Closure;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        $is_admin = Admin::where('user_id', $user->id)->first();

        if (!$is_admin) {
            return Api::response(403, "Forbidden: Access is denied (Admin-only API endpoint)");
        }

        return $next($request);
    }
}
