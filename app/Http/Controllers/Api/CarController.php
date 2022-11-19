<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as Controller;
use App\Http\Requests\CarRequest;
use App\Http\Services\CarService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

class CarController extends Controller
{
    private CarService $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    /**
     * @OA\Get(
     *     path="/cars",
     *     operationId="carsAll",
     *     tags={"Cars"},
     *     summary="Display a listing of the resource.",
     *     @OA\Response(
     *         response="200",
     *         description="Ok"
     *     )
     * )
     *
     * @return JsonResponse
     */
    public function index()
    {
        $cars = $this->carService->getCars();

        return response()->json(['cars' => $cars]);
    }

    /**
     * @OA\Post(
     *     path="/cars",
     *     operationId="createCar",
     *     tags={"Cars"},
     *     summary="Store a newly created resource in storage.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CarVirtual")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Ok"
     *     )
     * )
     *
     * @param CarRequest $request
     * @return JsonResponse
     */
    public function store(CarRequest $request)
    {
        $carRes = $this->carService->createCar($request);

        return response()->json(['car' => $carRes]);
    }

    /**
     * @OA\Get(
     *     path="/cars/{id}",
     *     operationId="car",
     *     tags={"Cars"},
     *     summary="Display a listing of the resource.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Car Id",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Ok"
     *     )
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $carRes = $this->carService->getCar($id);

        return response()->json(['car' => $carRes]);
    }

    /**
     * @OA\Put(
     *     path="/cars/{id}",
     *     operationId="updateCar",
     *     tags={"Cars"},
     *     summary="Update the specified resource in storage.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Car Id",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CarVirtual")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Ok"
     *     )
     * )
     *
     * @param CarRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(CarRequest $request, int $id)
    {
        $carRes = $this->carService->updateCar($request, $id);

        return response()->json(['car' => $carRes]);
    }

    /**
     * @OA\Delete(
     *     path="/cars/{id}",
     *     operationId="deleteCar",
     *     tags={"Cars"},
     *     summary="Remove the specified resource from storage.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Car Id",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Ok"
     *     )
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $this->carService->deleteCar($id);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
