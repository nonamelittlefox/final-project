<?php
/**
 * Created by VeHo.
 * Year: 2022-04-24
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleRequest;
use App\Repositories\Contracts\ScheduleRepositoryInterface;
use App\Http\Resources\BaseResource;
use App\Http\Resources\ScheduleResource;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{

     /**
     * var Repository
     */
    protected $repository;

    public function __construct(ScheduleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @OA\Get(
     *   path="/api/schedule",
     *   tags={"Schedule"},
     *   summary="List Schedule",
     *   operationId="schedule_index",
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
    public function index(ScheduleRequest $request)
    {
        $data = $this->repository->paginate($request->per_page);
        return $this->responseJson(200, BaseResource::collection($data));
    }

    /**
     * @OA\Post(
     *   path="/api/schedule",
     *   tags={"Schedule"},
     *   summary="Add new Schedule",
     *   operationId="schedule_create",
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
    public function store(ScheduleRequest $request)
    {
        try {
            $data = $this->repository->create($request->all());
            return $this->responseJson(200, new ScheduleResource($data));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @OA\Get(
     *   path="/api/schedule/{id}",
     *   tags={"Schedule"},
     *   summary="Detail Schedule",
     *   operationId="schedule_show",
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
            $department = $this->repository->find($id);
            return $this->responseJson(200, new BaseResource($department));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @OA\Post(
     *   path="/api/schedule/{id}",
     *   tags={"Schedule"},
     *   summary="Update Schedule",
     *   operationId="schedule_update",
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
    public function update(ScheduleRequest $request, $id)
    {
        $attributes = $request->except([]);
        $data = $this->repository->update($attributes, $id);
        return $this->responseJson(200, new BaseResource($data));
    }

    /**
     * @OA\Delete(
     *   path="/api/schedule/{id}",
     *   tags={"Schedule"},
     *   summary="Delete Schedule",
     *   operationId="schedule_delete",
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
