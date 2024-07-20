<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email', 'teste@email.com')->first()) {
            User::create([
                'name' => 'teste',
                'email' => 'teste@email.com',
                'password' => Hash::make('123456a',['rounds' => 12])
            ]);
        }
        if (!User::where('email', 'teste2@email.com')->first()) {
            User::create([
                'name' => 'teste2',
                'email' => 'teste2@email.com',
                'password' => Hash::make('123456a',['rounds' => 12])
            ]);
        }
        if (!User::where('email', 'teste3@email.com')->first()) {
            User::create([
                'name' => 'teste3',
                'email' => 'teste3@email.com',
                'password' => Hash::make('123456a',['rounds' => 12])
            ]);
        }
    }
}
