<?php

namespace App\Http\Middleware;

use App\Models\APIKeys;
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
        $apiKey = APIKeys::where('api_key', $apiKey)->first();

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

        return $next($request);
    }
}
