<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * @OA\Get(
     *      path="/activities",
     *      operationId="getActivitiesList",
     *      tags={"Activities"},
     *      summary="Get list of activities",
     *      description="Returns list of activities",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="Page",
     *          in="query",
     *          required=false,
     *          description="Page number",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *      ),
     *     @OA\Parameter(
     *          name="Per page",
     *          in="query",
     *          required=false,
     *          description="Items per page",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                property="data",
     *                type="array",
     *                example={{
     *                  "title": "aktivnost1",
                        "start_time": "2021-04-29T17:00:05",
                        "end_time": "2021-04-30T18:00:00",
                        "comment": "implementacija obrazca",
                        "id_assignments": "1",
                        "updated_at": "2021-04-28T15:13:29.000000Z",
                        "created_at": "2021-04-28T15:13:29.000000Z",
                        "id": 1
     *                }, {
     *                  "title": "aktivnost2",
                        "start_time": "2021-04-30T10:00:05",
                        "end_time": "2021-05-01T15:00:00",
                        "comment": "implementacija API",
                        "id_assignments": "2",
                        "updated_at": "2021-04-28T15:13:29.000000Z",
                        "created_at": "2021-04-28T15:13:29.000000Z",
                        "id": 2
     *                }},
     *                @OA\Items(
     *                  @OA\Property(property="title", type="string"),
     *                  @OA\Property(property="start_time", type="date"),
     *                  @OA\Property(property="end_time", type="date"),
     *                  @OA\Property(property="comment", type="string"),
     *                  @OA\Property(property="id_assignments", type="integer"),
     *                ),
     *             ),
     * )
     *
     *       )
     *     )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request):JsonResponse
    {
        return response()->json(Activity::paginate($request->get('per_page', 15)));
    }

    /**
     * @OA\Post(
     *      path="/activities",
     *      operationId="storeActivity",
     *      tags={"Activities"},
     *      summary="Store new activity",
     *      description="Returns activity data",
     *      security={{ "apiAuth": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(property="title", type="string"),
     *                  @OA\Property(property="start_time", type="date"),
     *                  @OA\Property(property="end_time", type="date"),
     *                  @OA\Property(property="comment", type="string"),
     *                  @OA\Property(property="id_assignments", type="integer")
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
     *                      @OA\Property(property="title", type="string"),
     *                      @OA\Property(property="start_time", type="date"),
     *                      @OA\Property(property="end_time", type="date"),
     *                      @OA\Property(property="comment", type="string"),
     *                      @OA\Property(property="id_assignments", type="integer"),
     *                      example={
     *                         "title": "aktivnost1",
                                "start_time": "2021-04-29T17:00:05",
                                "end_time": "2021-04-30T18:00:00",
                                "comment": "implementacija obrazca",
                                "id_assignments": "1",
                                "updated_at": "2021-04-28T15:13:29.000000Z",
                                "created_at": "2021-04-28T15:13:29.000000Z",
                                "id": 1
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
            'title' => 'required|string|max:50',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'comment' => 'required|string',
            'id_assignments' => 'required|integer'
        ]);

        return response()->json(Activity::create($validated), 201);
    }

    /**
     * @OA\Get(
     *      path="/activities/{id}",
     *      operationId="getActivityById",
     *      tags={"Activities"},
     *      summary="Get activity information",
     *      description="Returns activity data",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="Activity id",
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
     *                      @OA\Property(property="title", type="string"),
     *                      @OA\Property(property="start_time", type="date"),
     *                      @OA\Property(property="end_time", type="date"),
     *                      @OA\Property(property="comment", type="string"),
     *                      @OA\Property(property="id_assignments", type="integer"),
     *                      example={
     *                          "title": "aktivnost1",
                                "start_time": "2021-04-29T17:00:05",
                                "end_time": "2021-04-30T18:00:00",
                                "comment": "implementacija obrazca",
                                "id_assignments": "1",
                                "updated_at": "2021-04-28T15:13:29.000000Z",
                                "created_at": "2021-04-28T15:13:29.000000Z",
                                "id": 1
     *                     }
     *                 )
     *             )
     *         }
     *       )
     * )
     * @param Activity $activity
     * @return JsonResponse
     */
    public function show(Activity $activity):JsonResponse
    {
        return response()->json($activity);
    }

    /**
     * @OA\Put(
     *      path="/activities/{id}",
     *      operationId="updateActivity",
     *      tags={"Activities"},
     *      summary="Update existing activity",
     *      description="Returns updated activity data",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="Activity id",
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
     *                  @OA\Property(property="title", type="string"),
     *                  @OA\Property(property="start_time", type="date"),
     *                  @OA\Property(property="end_time", type="date"),
     *                  @OA\Property(property="comment", type="string"),
     *                  @OA\Property(property="id_assignments", type="integer")
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
     *                      @OA\Property(property="title", type="string"),
     *                      @OA\Property(property="start_time", type="date"),
     *                      @OA\Property(property="end_time", type="date"),
     *                      @OA\Property(property="comment", type="string"),
     *                      @OA\Property(property="id_assignments", type="integer"),
     *                      example=true
     *                 )
     *             )
     *         }
     *       )
     * )
     * @param Request $request
     * @param Activity $activity
     * @return JsonResponse
     */
    public function update(Request $request, Activity $activity):JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:50',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'comment' => 'required|string',
            'id_assignments' => 'required|integer'
        ]);

        return response()->json($activity->update($validated));
    }

    /**
     * @OA\Delete(
     *      path="/activities/{id}",
     *      operationId="deleteActivity",
     *      tags={"Activities"},
     *      summary="Delete existing activity",
     *      description="Deletes a record and returns no content",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="Activity id",
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
     * @param Activity $activity
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Activity $activity):JsonResponse
    {
        return response()->json($activity->delete(), 204);
    }
}
