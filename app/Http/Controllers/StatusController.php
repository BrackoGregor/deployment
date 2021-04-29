<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * @OA\Get(
     *      path="/statuses",
     *      operationId="getStatusesList",
     *      tags={"Assignment statuses"},
     *      summary="Get list of statuses",
     *      description="Returns list of statuses",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                property="data",
     *                type="array",
     *                example={{
     *                  "id": 1,
                        "name": "completed",
                        "created_at": "2021-04-22T16:12:24.000000Z",
                        "updated_at": "2021-04-22T16:12:24.000000Z",
                        "deleted_at": null
     *                }, {
     *                  "id": 2,
                        "name": "in progress",
                        "created_at": "2021-04-22T16:12:24.000000Z",
                        "updated_at": "2021-04-22T16:12:24.000000Z",
                        "deleted_at": null
     *                }},
     *                @OA\Items(
     *                  @OA\Property(property="name", type="string")
     *                ),
     *             ),
     * )
     *       )
     *     )
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request):JsonResponse
    {
        return response()->json(Status::paginate($request->get('per_page', 15)));
    }

    /**
     * @OA\Post(
     *      path="/statuses",
     *      operationId="storeStatus",
     *      tags={"Assignment statuses"},
     *      summary="Store new status",
     *      description="Returns status data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(property="name", type="string")
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created",
     *          content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                      @OA\Property(property="name", type="string"),
     *                      example={
     *                          "id": 3,
                                "name": "waiting",
                                "created_at": "2021-04-22T16:12:24.000000Z",
                                "updated_at": "2021-04-22T16:12:24.000000Z",
                                "deleted_at": null
     *                     }
     *                 )
     *             )
     *         }
     *       )
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request):JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:20'
        ]);

        return response()->json(Status::create($validated), 201);
    }

    /**
     * @OA\Get(
     *      path="/statuses/{status}",
     *      operationId="getStatusById",
     *      tags={"Assignment statuses"},
     *      summary="Get status information",
     *      description="Returns status data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Status id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                      @OA\Property(property="name", type="string"),
     *                      example={
     *                          "id": 1,
                                "name": "completed",
                                "created_at": "2021-04-22T16:12:24.000000Z",
                                "updated_at": "2021-04-22T16:12:24.000000Z",
                                "deleted_at": null
     *                     }
     *                 )
     *             )
     *         }
     *       )
     * )
     * @param Status $status
     * @return JsonResponse
     */
    public function show(Status $status):JsonResponse
    {
        return response()->json($status);
    }

    /**
     * @OA\Put(
     *      path="/statuses/{status}",
     *      operationId="updateStatus",
     *      tags={"Assignment statuses"},
     *      summary="Update existing status",
     *      description="Returns updated status data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Status id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(property="name", type="string")
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                      @OA\Property(property="name", type="string"),
     *                      example=true
     *                 )
     *             )
     *         }
     *       )
     * )
     * @param Request $request
     * @param Status $status
     * @return JsonResponse
     */
    public function update(Request $request, Status $status):JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:20'
        ]);

        return response()->json($status->update($validated));
    }

    /**
     * @OA\Delete(
     *      path="/statuses/{status}",
     *      operationId="deleteStatus",
     *      tags={"Assignment statuses"},
     *      summary="Delete existing status",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Status id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="No content"
     *       )
     * )
     * @param Status $status
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Status $status):JsonResponse
    {
        return response()->json($status->delete(), 204);
    }
}
