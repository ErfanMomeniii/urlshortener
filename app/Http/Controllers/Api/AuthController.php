<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\TokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use MiladRahimi\Jwt\Exceptions\InvalidKeyException;
use MiladRahimi\Jwt\Exceptions\JsonEncodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;

class AuthController extends Controller
{
    /**
     * @throws SigningException
     * @throws InvalidKeyException
     * @throws JsonEncodingException
     */
    public function register(Request $request, TokenService $tokenService): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'username' => 'required|min:5|max:30',
            'password' => 'required|min:6|max:20'
        ]);

        $user = new User();
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return response()->json([
            'access_token' => $tokenService->generateUserToken($user)
        ]);
    }

    /**
     * @throws InvalidKeyException
     * @throws SigningException
     * @throws JsonEncodingException
     */
    public function login(Request $request, TokenService $tokenService): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', '=', $request->input('username'))
            ->first();

        if ($user == null) {
            return response()->json([
                'error' => 'unauthorized'
            ])->setStatusCode(401);
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'error' => 'unauthorized'
            ])->setStatusCode(401);
        }

        return response()->json([
            'access_token' => $tokenService->generateUserToken($user)
        ]);
    }
}
