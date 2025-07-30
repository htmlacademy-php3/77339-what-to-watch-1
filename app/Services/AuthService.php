<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function register(array $data): User
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function login(array $data): string
    {
        if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            throw ValidationException::withMessages(['email' => ['Неверные данные для входа']]);
        }

        /** @var User $user */
        $user = Auth::user();
        return $user->createToken('auth_token')->plainTextToken;
    }

    public function logout(): void
    {
        Auth::user()->currentAccessToken()->delete();
    }
}
