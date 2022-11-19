<?php

namespace App\Http\Services;

use App\Http\Dto\CarDto;
use App\Http\Requests\CarRequest;
use App\Http\Transformers\CarTransformer;
use App\Models\Car;
use App\Models\User;

class CarService
{
    public function getCars(): array
    {
        $cars = Car::with('user')->get();

        return CarTransformer::createDtoList(...$cars);
    }

    public function getCar(int $id): CarDto
    {
        $car = Car::find($id);

        return CarTransformer::createDto($car);
    }

    public function createCar(CarRequest $request): CarDto
    {
        /** @var User $user */
        $user = User::find($request['userId']);

        if (!$user || $user->car instanceof Car) {
            $carRes = Car::create($request->validated());
        } else {
            $car = new Car();
            $car->name = $request['name'];

            $carRes = $user->car()->save($car);
        }

        return CarTransformer::createDto($carRes);
    }

    public function updateCar(CarRequest $request, int $id): CarDto
    {
        /** @var User $user */
        $user = User::find($request['userId']);
        /** @var Car $car */
        $car = Car::find($id);

        if (
            $user
            && $user->car === null
            && $car
            && $car->user === null
        ) {
            $car->user()->associate($user);
            $car->save();
        }

        $car->update($request->validated());

        return CarTransformer::createDto($car);
    }

    public function deleteCar(int $id): void
    {
        $car = Car::find($id);

        $car->delete();
    }
}
