<?php

namespace App\Http\Transformers;

use App\Http\Dto\CarDto;
use App\Http\Dto\UserDto;
use App\Models\Car;

class CarTransformer
{
    public static function createDtoList(Car ...$cars): array
    {
        return array_map(fn(Car $car) => self::createDto($car), $cars);
    }

    public static function createDto(?Car $car = null): CarDto
    {
        $carDto = new CarDto();

        if ($car instanceof Car) {
            $carDto->id = $car->id;
            $carDto->name = $car->name;
            $carDto->createdAt = $car->created_at;
            $carDto->user = self::getUserDto($car);
        }

        return $carDto;
    }

    public static function createShortDto(Car $car): CarDto
    {
        $carDto = new CarDto();
        $carDto->id = $car->id;
        $carDto->name = $car->name;
        $carDto->createdAt = $car->created_at;

        return $carDto;
    }

    private static function getUserDto(Car $car): ?UserDto
    {
        if ($car->user === null) {
            return null;
        }

        return UserTransformer::createShortDto($car->user);
    }
}
