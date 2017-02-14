<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\EnvironmentHelper;

class SignatureMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        if (!EnvironmentHelper::isDebug()) {
            $stringToHash = '';
            $hashedString = '';

            if (!$request->header('signature')) {
                throw new \Exception("Error Processing Request", 400);
            }

            $parameters = $request->all();

            ksort($parameters);

            foreach ($parameters as $key => $parameter) {
                $stringToHash .= $parameter; 
            }

            $hashedtring = hash_hmac('sha256', $stringToHash, env('APP_CLIENT_SECRET'));

            if ($hashedString != $request->header('signature')) {
                throw new \Exception("Error Processing Request", 400);
            }
        }

        return $next($request);
    }
}
