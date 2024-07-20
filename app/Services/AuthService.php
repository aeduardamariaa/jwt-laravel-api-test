<?php

namespace App\Services;

use App\Interfaces\AuthServiceInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Dto\AuthDto\AuthDto;
use App\Dto\UserDto\UserDto;

class AuthService implements AuthServiceInterface
{
    public function login(array $credentials): AuthDto
    {
        if (!$token = auth('api')->attempt($credentials)) {
            throw new \Exception('Unauthorized', 401);
        }

        return new AuthDto($token, 'bearer', auth('api')->factory()->getTTL() * 180);
    }

    public function logout(): void
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }

    public function refresh(): AuthDto
    {
        $token = auth('api')->refresh();
        return new AuthDto($token, 'bearer', auth('api')->factory()->getTTL() * 180);
    }

    public function me(): UserDto
    {
        $user = auth('api')->user();
        return new UserDto($user->id, $user->name, $user->email);
    }
}
