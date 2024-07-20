<?php

namespace App\Interfaces;

use App\Dto\UserDto\UserDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserServiceInterface
{
    public function getAllUsers(): LengthAwarePaginator;
    public function getUserById(int $id): UserDTO;
    public function createUser(array $data): UserDTO;
    public function updateUser(int $id, array $data): UserDTO;
    public function deleteUser(int $id): void;
}