<?php

namespace App\Http\Services;

use App\Http\Dto\UserDto;
use App\Http\Requests\UserRequest;
use App\Http\Transformers\UserTransformer;
use App\Models\User;

class UserService
{
    public function getUsers(): array
    {
        $users = User::with('car')->get();

        return UserTransformer::createDtoList(...$users);
    }

    public function getUser(int $id): UserDto
    {
        $user = User::find($id);

        return UserTransformer::createDto($user);
    }

    public function createUser(UserRequest $request): UserDto
    {
        $user = User::create($request->validated());

        return UserTransformer::createDto($user);
    }

    public function updateUser(UserRequest $request, int $id): UserDto
    {
        $user = User::find($id);

        $user->update($request->validated());

        return UserTransformer::createDto($user);
    }

    public function deleteUser(int $id): void
    {
        $user = User::find($id);

        $user->delete();
    }
}
