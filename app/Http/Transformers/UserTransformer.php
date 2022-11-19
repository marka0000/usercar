<?php

namespace App\Http\Transformers;

use App\Http\Dto\CarDto;
use App\Http\Dto\UserDto;
use App\Models\Car;
use App\Models\User;

class UserTransformer
{
    public static function createDtoList(User ...$users): array
    {
        return array_map(fn(User $user) => self::createDto($user), $users);
    }

    public static function createDto(?User $user = null): UserDto
    {
        $userDto = new UserDto();

        if ($user instanceof User) {
            $userDto->id = $user->id;
            $userDto->name = $user->name;
            $userDto->createdAt = $user->created_at;
            $userDto->car = self::getCarDto($user);
        }

        return $userDto;
    }

    public static function createShortDto(User $user): UserDto
    {
        $userDto = new UserDto();
        $userDto->id = $user->id;
        $userDto->name = $user->name;
        $userDto->createdAt = $user->created_at;

        return $userDto;
    }

    private static function getCarDto(User $user): ?CarDto
    {
        if ($user->car === null) {
            return null;
        }

        return CarTransformer::createShortDto($user->car);
    }
}
