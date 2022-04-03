<?php

namespace App\Http\Middleware;


use App\Models\User;
use App\Services\TokenService;
use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use MiladRahimi\Jwt\Exceptions\InvalidKeyException;
use MiladRahimi\Jwt\Exceptions\InvalidSignatureException;
use MiladRahimi\Jwt\Exceptions\InvalidTokenException;
use MiladRahimi\Jwt\Exceptions\JsonDecodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;
use MiladRahimi\Jwt\Exceptions\ValidationException;

class ApiTokenCheck
{
    /**
     * @throws InvalidTokenException
     * @throws SigningException
     * @throws ValidationException
     * @throws InvalidKeyException
     * @throws InvalidSignatureException
     * @throws JsonDecodingException
     * @throws BindingResolutionException
     */
    public function handle(Request $request, Closure $next): \Illuminate\Http\JsonResponse
    {
        if ($request->header('authorization') == null) {
            return response()->json([
                'error' => 'unauthorized'
            ])
                ->setStatusCode(401);
        }

        $claims = app()->make(TokenService::class)->parseUserToken($request->header('authorization'));

        if (!User::find($claims['id'])) {
            return response()->json([
                'error' => 'unauthorized'
            ])
                ->setStatusCode(401);
        }

        if ($claims['expire_seconds'] < time()) {
            return response()->json([
                'error' => 'token expired'
            ])
                ->setStatusCode(401);
        }

        return $next($request);
    }
}
