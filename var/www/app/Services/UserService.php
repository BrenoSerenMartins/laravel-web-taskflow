<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function create($userData): User
    {
        removeEmptyOptionalFields(User::OPTIONAL_FIELDS, $userData);

        return User::create($userData);
    }

    public function login(array $loginData): bool
    {
        $auth = Auth::attempt(['email' => $loginData['email'], 'password' => $loginData['password']]);
        if ($auth) {
            return true;
        }
        return false;
    }

    public function logout(): void
    {
        Auth::logout();
    }
}
