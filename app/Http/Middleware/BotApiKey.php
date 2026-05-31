<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BotApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $key = config('app.bot_api_key');

        if (! $key || $request->header('X-Bot-Key') !== $key) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
