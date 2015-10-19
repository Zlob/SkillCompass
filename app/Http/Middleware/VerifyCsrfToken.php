<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use App\Http\Middleware\Closure as Closure;
use Log;
use Illuminate\Support\Str;

class VerifyCsrfToken extends BaseVerifier
{
        
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
//         'api/*'
    ];
    
    /**
     * Determine if the session and input CSRF tokens match.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function tokensMatch($request)
    {
        $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');

        if (! $token && $header = $request->header('X-XSRF-TOKEN')) {
            $token = $this->encrypter->decrypt($header);
        }

        if(!Str::equals($request->session()->token(), $token)){
            Log::info($request->session()->token().";".$token);
        }
        return Str::equals($request->session()->token(), $token);
    }

}
