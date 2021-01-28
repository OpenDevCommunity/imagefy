<?php

namespace App\Http\Middleware;

use App\Models\APIKey;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class APIKeyMiddleware
{

    /**
     * Check if API Key exists
     * @param $apiKey
     * @return bool
     */
    private function keyExists($apiKey)
    {
        $apiKey = APIKey::where('api_key', $apiKey)->first();

        return $apiKey ? true : false;
    }


    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $apiKey = $request->headers->get('x-api-key');

        // There was no API key
        if (!$apiKey) {
            return response()->json([
                'error' => true,
                'msg'   => "API Key was not supplied with request!"
            ], 401);
        }

        // Check if API Key exists
        if (!$this->keyExists($apiKey)) {
            return response()->json([
                'error' => true,
                'msg'   => "Supplied API Key does not exist!"
            ], 401);
        }


        $key = APIKey::where('api_key', $apiKey)->first();

        // Check if API Key is enabled
        if (!$key->enabled || $key->blocked) {
            return response()->json([
                'error' => true,
                'msg' => "API Key is disabled or blocked!"
            ]);
        }

        if ($_SERVER['HTTP_HOST'] !== $key->allowed_origin && $key->allowed_origin !== '*') {
            return response()->json([
                'error' => true,
                'msg' => "HTTP_HOST mismach in allowed origin"
            ]);
        }


        // Update API Key last used date
        APIKey::where('api_key', $apiKey)->update(['last_used' => Carbon::now()]);

        return $next($request);
    }
}
