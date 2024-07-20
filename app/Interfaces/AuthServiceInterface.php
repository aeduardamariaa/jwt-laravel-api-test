<?php

namespace App\Interfaces;

use App\Dto\AuthDto\AuthDto;
use App\Dto\UserDto\UserDto;

interface AuthServiceInterface
{
    public function login(array $credentials): AuthDto;
    public function logout(): void;
    public function refresh(): AuthDto;
    public function me(): UserDto;
}
