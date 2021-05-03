<?php

namespace App\Http\Controllers;

use App\Models\User_Assignment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserAssignmentController extends Controller
{
    /**
     * @OA\Get(
     *      path="/userAssignments",
     *      operationId="getuserAssignmentsList",
     *      tags={"User Assignments"},
     *      summary="Get list of userAssignments",
     *      description="Returns list of userAssignments",
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
     *          description="Successful operation",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                property="data",
     *                type="array",
     *                example={{
     *                  "id": 1,
                        "id_users": 1,
                        "id_assignments": 1,
                        "created_at": "2021-04-29T07:30:27.000000Z",
                        "updated_at": "2021-04-29T07:30:27.000000Z",
                        "deleted_at": null
     *                }, {
     *                  "id": 2,
                        "id_users": 1,
                        "id_assignments": 2,
                        "created_at": "2021-04-29T07:30:38.000000Z",
                        "updated_at": "2021-04-29T07:30:38.000000Z",
                        "deleted_at": null
     *                }},
     *                @OA\Items(
     *                  @OA\Property(property="id_users", type="integer"),
     *                  @OA\Property(property="id_assignments", type="integer")
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
        return response()->json(User_Assignment::paginate($request->get('per_page', 15)));
    }

    /**
     * @OA\Post(
     *      path="/userAssignments",
     *      operationId="storeuserAssignment",
     *      tags={"User Assignments"},
     *      summary="Store new userAssignment",
     *      description="Returns userAssignment data",
     *      security={{ "apiAuth": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(property="id_users", type="integer"),
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
     *                      @OA\Property(property="id_users", type="integer"),
     *                      @OA\Property(property="id_assignments", type="integer"),
     *                      example={
     *                          "id": 2,
                                "id_users": 1,
                                "id_assignments": 2,
                                "created_at": "2021-04-29T07:30:38.000000Z",
                                "updated_at": "2021-04-29T07:30:38.000000Z",
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
            'id_users' => 'required|integer',
            'id_assignments' => 'required|integer'
        ]);

        return response()->json(User_Assignment::create($validated), 201);
    }

    /**
     * @OA\Get(
     *      path="/userAssignments/{id}",
     *      operationId="getuserAssignmentById",
     *      tags={"User Assignments"},
     *      summary="Get userAssignment information",
     *      description="Returns userAssignments data",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="userAssignment id",
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
     *                      @OA\Property(property="id_users", type="integer"),
     *                      @OA\Property(property="id_assignments", type="integer"),
     *                      example={
     *                          "id": 1,
                                "id_users": 1,
                                "id_assignments": 1,
                                "created_at": "2021-04-29T07:30:27.000000Z",
                                "updated_at": "2021-04-29T07:30:27.000000Z",
                                "deleted_at": null
     *                     }
     *                 )
     *             )
     *         }
     *       )
     * )
     * @param User_Assignment $userAssignment
     * @return JsonResponse
     */
    public function show(User_Assignment $userAssignment):JsonResponse
    {
        return response()->json($userAssignment);
    }

    /**
     * @OA\Put(
     *      path="/userAssignments/{id}",
     *      operationId="updateuserAssignment",
     *      tags={"User Assignments"},
     *      summary="Update existing userAssignment",
     *      description="Returns updated userAssignment data",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="userAssignment id",
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
     *                  @OA\Property(property="id_users", type="integer"),
 *                      @OA\Property(property="id_assignments", type="integer")
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
     *                      @OA\Property(property="id_users", type="integer"),
     *                      @OA\Property(property="id_assignments", type="integer"),
     *                      example=true
     *                 )
     *             )
     *         }
     *       )
     * )
     * @param Request $request
     * @param User_Assignment $userAssignment
     * @return JsonResponse
     */
    public function update(Request $request, User_Assignment $userAssignment):JsonResponse
    {
        $validated = $request->validate([
            'id_users' => 'required|integer',
            'id_assignments' => 'required|integer'
        ]);

        return response()->json($userAssignment->update($validated));
    }

    /**
     * @OA\Delete(
     *      path="/userAssignments/{id}",
     *      operationId="deleteuserAssignment",
     *      tags={"User Assignments"},
     *      summary="Delete existing userAssignment",
     *      description="Deletes a record and returns no content",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="userAssignment id",
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
     * @param User_Assignment $userAssignment
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(User_Assignment $userAssignment):JsonResponse
    {
        return response()->json($userAssignment->delete(), 204);
    }
}
