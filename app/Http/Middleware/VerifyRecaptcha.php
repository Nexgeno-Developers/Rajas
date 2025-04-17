<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VerifyRecaptcha
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->input('recaptcha_token');

        if (!$token) {
            Log::warning('reCAPTCHA token missing', [
                'ip' => $request->ip(),
                'route' => $request->path(),
                'timestamp' => now(),
            ]);
            abort(422, 'reCAPTCHA token is missing.');
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $token,
            'remoteip' => $request->ip(),
        ]);

        $result = $response->json();
        //dd($result);
        if (!isset($result['success']) || !$result['success'] || $result['score'] < 0.5) {
            Log::error('reCAPTCHA validation failed', [
                'ip' => $request->ip(),
                'route' => $request->path(),
                'score' => $result['score'] ?? null,
                'result' => $result,
                'timestamp' => now(),
            ]);
            abort(403, 'reCAPTCHA validation failed.');
        }

        return $next($request);
    }
}
