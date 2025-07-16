<?php

namespace App\Services\User;

use App\Enums\User\RoleEnum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StoreService
{
    public function __invoke(array $validated): User
    {
        return User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'] ?? RoleEnum::USER->value,
        ]);
    }
}