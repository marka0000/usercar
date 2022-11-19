<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="API for project usercar",
 *     version="1.0"
 * )
 * @OA\Tag(
 *     name="Users",
 *     description="Users page"
 * )
 * @OA\Tag(
 *     name="Cars",
 *     description="Cars page"
 * )
 * @OA\Server(
 *     description="API server",
 *     url="http://localhost:8000/api"
 * )
 */
class BaseController extends Controller
{
}
