<?php

/**
 * Created by VeHo.
 * Year: 2022-04-21
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuildingRequest;
use App\Repositories\Contracts\BuildingRepositoryInterface;
use App\Http\Resources\BaseResource;
use App\Http\Resources\BuildingResource;
use Illuminate\Http\Request;

class BuildingController extends Controller
{

  /**
   * var Repository
   */
  protected $buildingRepository;

  public function __construct(BuildingRepositoryInterface $buildingRepository)
  {
      $this->buildingRepository = $buildingRepository;
  }

  /**
   * @OA\Get(
   *   path="/api/building",
   *   tags={"Building"},
   *   summary="List Building",
   *   operationId="building_index",
   *   @OA\Response(
   *     response=200,
   *     description="Send request success",
   *     @OA\MediaType(
   *      mediaType="application/json",
   *      example={"code":200,"data":{{"id": 1,"name": "..........."}}}
   *     )
   *   ),
   *   @OA\Parameter(
   *     name="page",
   *     in="query",
   *     @OA\Schema(
   *      type="integer",
   *     ),
   *   ),
   *   @OA\Parameter(
   *     name="per_page",
   *     in="query",
   *     @OA\Schema(
   *      type="integer",
   *     ),
   *   ),
   *   @OA\Response(
   *     response=401,
   *     description="Login false",
   *     @OA\MediaType(
   *      mediaType="application/json",
   *      example={"code":401,"message":"Username or password invalid"}
   *     )
   *   ),
   *   security={{"auth": {}}},
   * )
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(BuildingRequest $request)
  {
    $building = $this->buildingRepository->getPagination($request);
    return $this->responseJson(200, BuildingResource::collection($building));
  }

  /**
   * @OA\Post(
   *   path="/api/building",
   *   tags={"Building"},
   *   summary="Add new Building",
   *   operationId="building_create",
   *   @OA\Parameter(name="name", in="query", required=true,
   *     @OA\Schema(type="string"),
   *   ),
   *
   *   @OA\Response(
   *     response=200,
   *     description="Send request success",
   *     @OA\MediaType(
   *      mediaType="application/json",
   *      example={"code":200,"data":{"id": 1,"name": "......"}}
   *     )
   *   ),
   *   security={{"auth": {}}},
   * )
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception
   */
  public function store(BuildingRequest $request)
  {
    try {
      $data = $this->repository->create($request->all());
      return $this->responseJson(200, new BuildingResource($data));
    } catch (\Exception $e) {
      throw $e;
    }
  }

  /**
   * @OA\Get(
   *   path="/api/building/{id}",
   *   tags={"Building"},
   *   summary="Detail Building",
   *   operationId="building_show",
   *   @OA\Parameter(
   *     name="id",
   *     in="path",
   *     required=true,
   *     @OA\Schema(
   *      type="string",
   *     ),
   *   ),
   *   @OA\Response(
   *     response=200,
   *     description="Send request success",
   *     @OA\MediaType(
   *      mediaType="application/json",
   *      example={"code":200,"data":{"id": 1,"name":"......"}}
   *     )
   *   ),
   *   @OA\Response(
   *     response=401,
   *     description="Login false",
   *     @OA\MediaType(
   *      mediaType="application/json",
   *      example={"code":401,"message":"Username or password invalid"}
   *     )
   *   ),
   *   security={{"auth": {}}},
   * )
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    try {
      $building = $this->repository->find($id);
      return $this->responseJson(200, new BaseResource($building));
    } catch (\Exception $e) {
      throw $e;
    }
  }

  /**
   * @OA\Post(
   *   path="/api/building/{id}",
   *   tags={"Building"},
   *   summary="Update Building",
   *   operationId="building_update",
   *   @OA\Parameter(
   *     name="id",
   *     in="path",
   *     required=true,
   *     @OA\Schema(
   *      type="string",
   *     ),
   *   ),
   *   @OA\RequestBody(
   *       @OA\MediaType(
   *          mediaType="application/json",
   *          example={"name":"string"},
   *          @OA\Schema(
   *            required={"name"},
   *            @OA\Property(
   *              property="name",
   *              format="string",
   *            ),
   *         )
   *      )
   *   ),
   *   @OA\Response(
   *     response=200,
   *     description="Send request success",
   *     @OA\MediaType(
   *      mediaType="application/json",
   *      example={"code":200,"data":{"id": 1,"name":  "............."}}
   *     ),
   *   ),
   *   @OA\Response(
   *     response=403,
   *     description="Access Deny permission",
   *     @OA\MediaType(
   *      mediaType="application/json",
   *      example={"code":403,"message":"Access Deny permission"}
   *     ),
   *   ),
   *   security={{"auth": {}}},
   * )
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(BuildingRequest $request, $id)
  {
    $attributes = $request->except([]);
    $data = $this->repository->update($attributes, $id);
    return $this->responseJson(200, new BaseResource($data));
  }

  /**
   * @OA\Delete(
   *   path="/api/building/{id}",
   *   tags={"Building"},
   *   summary="Delete Building",
   *   operationId="building_delete",
   *   @OA\Parameter(
   *      name="id",
   *      in="path",
   *      required=true,
   *     @OA\Schema(
   *      type="string",
   *     ),
   *   ),
   *   @OA\Response(
   *     response=200,
   *     description="Send request success",
   *     @OA\MediaType(
   *      mediaType="application/json",
   *      example={"code":200,"data":"Send request success"}
   *     )
   *   ),
   *   security={{"auth": {}}},
   * )
   * @param int $id
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception
   */
  public function destroy($id)
  {
    $this->repository->delete($id);
    return $this->responseJson(200, null, trans('messages.mes.delete_success'));
  }
}
