<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\TokenService;
use Illuminate\Auth\Access\AuthorizationException;
use MiladRahimi\Jwt\Exceptions\InvalidKeyException;
use MiladRahimi\Jwt\Exceptions\InvalidSignatureException;
use MiladRahimi\Jwt\Exceptions\InvalidTokenException;
use MiladRahimi\Jwt\Exceptions\JsonDecodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;
use MiladRahimi\Jwt\Exceptions\ValidationException;

class UsersController extends Controller
{
    /**
     * @throws InvalidTokenException
     * @throws SigningException
     * @throws ValidationException
     * @throws InvalidKeyException
     * @throws InvalidSignatureException
     * @throws JsonDecodingException
     * @throws AuthorizationException
     */
    public function show(User $user, TokenService $tokenService): \Illuminate\Http\JsonResponse
    {
        $this->authorizeForUser($tokenService->parseUserFromUserToken(\request()->header('authorization'))
            , 'viewAny', User::class);

        return response()->json($user);
    }

    /**
     * @throws InvalidTokenException
     * @throws SigningException
     * @throws ValidationException
     * @throws InvalidSignatureException
     * @throws InvalidKeyException
     * @throws JsonDecodingException
     * @throws AuthorizationException
     */
    public function destroy(User $user, TokenService $tokenService): \Illuminate\Http\JsonResponse
    {
        $this->authorizeForUser($tokenService->parseUserFromUserToken(\request()->header('authorization'))
            , 'delete', User::class);

        $user->delete();

        return response()->json([
            'message' => 'successful'
        ]);
    }
}
