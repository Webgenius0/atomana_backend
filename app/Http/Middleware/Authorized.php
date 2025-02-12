<?php

namespace App\Http\Middleware;

use App\Traits\V1\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Authorized
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user && in_array(optional($user->role)->slug, ['agent', 'admin'])) {
            return $next($request);
        }
        return $this->error(403, 'Only Admins & Agents are Allowed to Access');
    }
}
