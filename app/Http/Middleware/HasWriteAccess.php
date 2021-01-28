<?php

namespace App\Http\Middleware;

use App\Models\APIKey;
use Closure;
use Illuminate\Http\Request;

class HasWriteAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->headers->get('x-api-key');

        $key = APIKey::where('api_key', $apiKey)->first();

        if (!$key->can_write) {
            return response()->json([
                'error' => true,
                'msg' => 'Access denied!'
            ], 401);
        }

        return $next($request);
    }
}
