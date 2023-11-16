<?php

namespace App\Http\Middleware;

use App\Models\AccessLog;
use Closure;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent; // Import the Agent class

class LogAccess
{
    public function handle($request, Closure $next)
    {

      
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();

        // Extract the operating system from the user agent string
        $operatingSystem = $this->getOS($userAgent);

        // Check if the access is successful or failed based on your logic
        $status = $this->isAccessSuccessful($request);

        AccessLog::create([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'operating_system' => $operatingSystem,
            'access_time' => now(),
            'status' => $status,
        ]);

        return $next($request);
    }

    private function isAccessSuccessful($request)
    {
        if (Auth::check()) {
            // You can add additional authorization checks here based on your application's requirements.
            // For example, check if the user has permission to access a particular resource.
            return 'success'; // Access is successful
        }

        return 'failed'; // Access is failed (not authenticated)
    }

    private function getOS($userAgent)
    {
        $agent = new Agent();
        $agent->setUserAgent($userAgent);

        // Extract the operating system from the user agent string
        return $agent->platform();
    }
}
