<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AuthRefreshRequest;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Requests\V1\RegisterRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use App\Passport\Traits\AuthPassportTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    use AuthPassportTrait;


    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function registerOld(RegisterRequest $request): JsonResponse
    {
        $input = $request->validated();

        $input['password'] = bcrypt($input['password']);
        /** @var User $user */
        $user = User::create($input);
        $user = User::find($user->id);

        $token = $user->createToken('access_token')->accessToken;

        if ($token) {

            return response()->json([
                'user' => new UserResource($user),
                'access_token' => $token
            ]);
        }
        else {

            return response()->json([
                'message' => "Register error"
            ], 401);
        }
    }


    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     * @throws \App\Passport\ClientAbsentException
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $input = $request->validated();

        $input['password'] = bcrypt($input['password']);
        /** @var User $user */
        $user = User::create($input);

        $result = self::getToken(User::PASSPORT_CLIENT_NAME, $input['email'], $request->get('password'));

        if (!$result->error) {

            return response()->json([
                'success' => true,
                'user' => new UserResource($user),
                'authorization' => $result->token
            ]);
        }
        else {

            return response()->json([
                'success' => false,
                'error'   => $result->error,
                'message' => $result->error_message
            ], 401);
        }
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function loginOld(LoginRequest $request): JsonResponse
    {
        $creds = $request->only('email', 'password');

        try {

            if (Auth::attempt($creds)) {

                $user = Auth::user();

                if ($user) {

                    $token = $user->createToken('access_token')->accessToken;


                    if ($token) {

                        return response()->json([
                            'user' => new UserResource($user),
                            'token' => $token
                        ]);
                    }
                    else {

                        return response()->json([
                            'message' => __('auth.token.cant')
                        ], 401);
                    }
                }
            }

        } catch (\Exception $e) {

            Log::info('LOGIN Error message: ' . $e->getMessage());

            return response()->json([
                'message' => __('auth.token.cant')
            ], 422);
        }

        $request->authenticate(true);

        return response()->json(['message' => trans('auth.failed')], 422);
    }




    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        try {

            $remember = $request->input('remember');

            if (Auth::attempt($credentials, $remember)) {

                $user = Auth::user();

                if ($user) {

                    $result = self::getToken(User::PASSPORT_CLIENT_NAME, $credentials['email'], $credentials['password'], $remember);

                    if (!$result->error) {

                        return response()->json([
                            'success' => true,
                            'user' => new UserResource($user),
                            'authorization' => $result->token
                        ]);
                    }
                    else {

                        return response()->json([
                            'success' => false,
                            'error' => $result->error,
                            'message' => $result->error_message
                        ], 401);
                    }
                }
            }

        } catch (\Exception $e) {

            Log::info('LOGIN Error message: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => __('auth.token.cant')
            ], 422);
        }

//        $request->authenticate(true);

        return response()->json([
            'message' => trans('auth.failed')
        ], 422);
    }


    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $user->token()->revoke();
        return response()
            ->json([
                'success' => true,
                'message' => __("Successfully logged out"),
            ]);
    }


    public function unauthenticated()
    {
        return response()->json([
            "status" => false,
            "message" => "Unauthenticated. Please login first",
        ], 401);
    }
}
