<?php

namespace App\Http\Middleware;


use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;
use MiladRahimi\Jwt\Exceptions\InvalidKeyException;
use MiladRahimi\Jwt\Exceptions\InvalidSignatureException;
use MiladRahimi\Jwt\Exceptions\InvalidTokenException;
use MiladRahimi\Jwt\Exceptions\JsonDecodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;
use MiladRahimi\Jwt\Exceptions\ValidationException;
use MiladRahimi\Jwt\Parser;

class ApiTokenCheck
{
    /**
     * @throws InvalidTokenException
     * @throws SigningException
     * @throws ValidationException
     * @throws InvalidKeyException
     * @throws InvalidSignatureException
     * @throws JsonDecodingException
     */
    public function handle(Request $request, Closure $next): \Illuminate\Http\JsonResponse
    {
        $signer = new HS256(env('HASH_KEY'));
        $parser = new Parser($signer);
        $claims = $parser->parse($request->header('authorization'));

        if (!(new \App\Models\User)->find($claims['id'])) {
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
