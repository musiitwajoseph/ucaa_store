<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuditMiddleware
{
    /**
     * Routes to exclude from audit logging.
     */
    protected $except = [
        'logout',
        '_debugbar',
        'horizon',
        'telescope',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only log for authenticated users
        if (Auth::check() && !$this->shouldExclude($request)) {
            $this->logActivity($request, $response);
        }

        return $response;
    }

    /**
     * Log the user activity.
     */
    protected function logActivity(Request $request, Response $response)
    {
        // Skip non-GET requests (they're usually logged by model events)
        if (!$request->isMethod('GET')) {
            return;
        }

        // Skip AJAX requests
        if ($request->ajax()) {
            return;
        }

        // Only log successful responses
        if ($response->getStatusCode() >= 400) {
            return;
        }

        $event = $this->determineEvent($request);
        
        if ($event) {
            AuditLog::create([
                'user_id' => Auth::id(),
                'event' => $event,
                'auditable_type' => null,
                'auditable_id' => null,
                'old_values' => null,
                'new_values' => null,
                'url' => $request->fullUrl(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'description' => $this->getDescription($request, $event),
            ]);
        }
    }

    /**
     * Determine the event type based on the request.
     */
    protected function determineEvent(Request $request)
    {
        $path = $request->path();

        // Skip common routes
        if (in_array($path, ['dashboard', 'home', '/'])) {
            return null;
        }

        // Check for specific patterns
        if (str_contains($path, '/export')) {
            return 'exported';
        }

        if (str_contains($path, '/download')) {
            return 'downloaded';
        }

        if (str_contains($path, '/print')) {
            return 'printed';
        }

        // Default to page view
        return 'page_viewed';
    }

    /**
     * Get a human-readable description.
     */
    protected function getDescription(Request $request, $event)
    {
        $path = $request->path();
        
        $descriptions = [
            'exported' => "Exported data from {$path}",
            'downloaded' => "Downloaded file from {$path}",
            'printed' => "Printed from {$path}",
            'page_viewed' => "Viewed page: {$path}",
        ];

        return $descriptions[$event] ?? "Accessed {$path}";
    }

    /**
     * Check if the request should be excluded from audit logging.
     */
    protected function shouldExclude(Request $request)
    {
        foreach ($this->except as $pattern) {
            if ($request->is($pattern) || str_contains($request->path(), $pattern)) {
                return true;
            }
        }

        return false;
    }
}
