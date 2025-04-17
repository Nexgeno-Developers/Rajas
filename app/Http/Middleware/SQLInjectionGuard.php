<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SQLInjectionGuard
{
    public function handle(Request $request, Closure $next)
    {
        // Retrieve all input data from the request
        $input = $request->all();

        // Define regex pattern to check for SQL Injection risk patterns
        $sqlInjectionPatterns = [
            '/union.*select.*\(/i', // Union select statement
            '/select.*from.*information_schema/i', // Information schema access
            '/drop.*table/i', // Drop table
            '/--|#|;/i', // Commenting SQL, semi-colon
            '/or\s+1=1/i', // Common SQL injection condition
            '/insert\s+into.*values/i', // Insert statement
        ];

        // Define fields that should be excluded from the check
        $excludeFields = [];
        //$excludeFields = ['password', 'recaptcha_token', '_token'];

        // Loop through input data and check for patterns
        foreach ($input as $key => $value) {
            // Skip excluded fields
            if (in_array($key, $excludeFields)) {
                continue;
            }

            if (is_string($value)) {
                foreach ($sqlInjectionPatterns as $pattern) {
                    if (preg_match($pattern, $value)) {
                        // Log the suspicious input
                        Log::warning('SQL Injection attempt detected', [
                            'input' => $input,
                            'user_ip' => $request->ip(),
                            'user_agent' => $request->header('User-Agent')
                        ]);

                        // Abort the request with a 400 error and custom message
                        abort(403, 'Invalid input detected. Please check your input and try again.');
                    }
                }
            }
        }

        // Continue processing the request if no suspicious patterns are found
        return $next($request);
    }
}

