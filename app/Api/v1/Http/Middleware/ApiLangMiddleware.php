<?php

namespace App\Api\v1\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Exception;

class ApiLangMiddleware extends BaseMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            if ($request->hasHeader('X-localization')) {
                $locale = $request->header('X-localization');
                App::setLocale($locale);
            }
        } catch (Exception $e) {
                //
        }

        return $next($request);
    }
}
