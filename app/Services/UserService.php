<?php

namespace App\Services;

use App\Models\User;
use App\DTO\UserDto\UserDto;
use App\Interfaces\UserServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class UserService implements UserServiceInterface
{
    public function getAllUsers(): LengthAwarePaginator
    {
        $users = User::orderBy('id', 'desc')->paginate(2);

        $userDTOs = $users->getCollection()->transform(function ($user) {
            return new UserDTO($user->id, $user->name, $user->email);
        });

        return new LengthAwarePaginator($userDTOs, $users->total(), $users->perPage(), $users->currentPage(), [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'pageName' => $users->getPageName(),
        ]);
    }
    
    public function getUserById(int $id): UserDto
    {
        $user = User::findOrFail($id);
        return new UserDto($user->id, $user->name, $user->email);
    }

    public function createUser(array $data): UserDto
    {
        DB::beginTransaction();
        
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            DB::commit();

            return new UserDto($user->id, $user->name, $user->email);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Usuário não cadastrado!", 400);
        }
    }

    public function updateUser(int $id, array $data): UserDto
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);
            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            DB::commit();

            return new UserDto($user->id, $user->name, $user->email);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Usuário não editado!", 400);
        }
    }

    public function deleteUser(int $id): void
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
        } catch (\Exception $e) {
            throw new \Exception("Usuário não deletado!", 400);
        }
    }
}