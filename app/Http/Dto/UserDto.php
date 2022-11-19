<?php

namespace App\Http\Dto;

class UserDto
{
    public int $id;
    public string $name;
    public string $createdAt;
    public ?CarDto $car;
}
