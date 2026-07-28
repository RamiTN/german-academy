<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $action = 'page_view'): Response
    {
        $response = $next($request);

        if ($request->user()) {
            ActivityLog::log(
                $action,
                $request->path()
            );
        }

        return $response;
    }
}
