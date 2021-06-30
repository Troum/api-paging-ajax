<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        try {
            $user = new User();
            $user->store($request);
            $access_token = $user->createToken('jwt_token')->accessToken;
            return response()->json([
                'success' => 'Вы успешно зарегистрировались',
                'access_token' => $access_token
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'error' => 'Произошла ошибка номер ' .
                    $exception->getCode() .
                    '. Для подробной информации проверьте логи'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * @return JsonResponse
     */
    public function user(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request) {
        try {
            $request->user()->token()->revoke();
            return response()->json([
                'success' => 'Вы успешно вышли из системы'
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'error' => 'Произошла ошибка номер ' .
                    $exception->getCode() .
                    '. Для подробной информации проверьте логи'
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function login(Request $request)
    {
        try {
            $user = User::where('email', '=', $request->username)
                ->first();
            $access_token = $user->createToken('jwt_token')->accessToken;
            return response([
                'success' => 'Вы успешно авторизовались',
                'access_token' => $access_token
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'error' => 'Произошла ошибка номер ' .
                    $exception->getCode() .
                    '. Для подробной информации проверьте логи'
            ], Response::HTTP_BAD_REQUEST);
        }

    }
}
