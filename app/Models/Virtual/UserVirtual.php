<?php

namespace App\Models\Virtual;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Virtual User model",
 *     type="object",
 * )
 */
class UserVirtual
{
    /**
     * @OA\Property(
     *     title="Name",
     *     description="Name user",
     *     format="string",
     * )
     * @var string
     */
    public $name;
}
