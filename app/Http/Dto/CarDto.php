<?php

namespace App\Http\Dto;

class CarDto
{
    public int $id;
    public string $name;
    public string $createdAt;
    public ?UserDto $user;
}
