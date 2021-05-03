<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{

    /**
     * @OA\Get(
     *      path="/assignments",
     *      operationId="getAssignmentsList",
     *      tags={"Assignments"},
     *      summary="Get list of assignments",
     *      description="Returns list of assignments",
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
     *     @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                property="data",
     *                type="array",
     *                example={{
     *                  "id": 1,
                        "work_description": "test",
                        "developer_description": "primer",
                        "id_clients": 1,
                        "id_statuses": 2,
                        "created_at": "2021-04-23T14:27:57.000000Z",
                        "updated_at": "2021-04-23T14:27:57.000000Z",
                        "deleted_at": null
     *                }, {
     *                  "id": 2,
                        "work_description": "novi",
                        "developer_description": "primer",
                        "id_clients": 2,
                        "id_statuses": 2,
                        "created_at": "2021-04-23T14:31:20.000000Z",
                        "updated_at": "2021-04-23T14:31:20.000000Z",
                        "deleted_at": null
     *                }, {
     *                  "id": 3,
                        "work_description": "noviProjekt",
                        "developer_description": "primer",
                        "id_clients": 2,
                        "id_statuses": 2,
                        "created_at": "2021-04-23T14:31:31.000000Z",
                        "updated_at": "2021-04-23T14:31:31.000000Z",
                        "deleted_at": null

     *                  }},
     *                @OA\Items(
     *                  @OA\Property(property="work_description", type="string"),
     *                  @OA\Property(property="developer_description", type="string"),
     *                  @OA\Property(property="id_clients", type="integer"),
     *                  @OA\Property(property="id_statuses", type="integer")
     *                ),
     *             ),
     * )
     *       )
     *     )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request):JsonResponse
    {
        return response()->json(Assignment::paginate($request->get('per_page', 15)));
    }

    /**
     * @OA\Get(
     *      path="/assignmentsClient/{id}",
     *      operationId="getAssignmentsList",
     *      tags={"Assignments"},
     *      summary="Get list of assignments for client",
     *      description="Returns list of assignments for specific client",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="Client id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
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
     *                  "id": 1,
                        "work_description": "test",
                        "developer_description": "primer",
                        "id_clients": 1,
                        "id_statuses": 2,
                        "created_at": "2021-04-23 14:27:57",
                        "updated_at": "2021-04-23 14:27:57",
                        "deleted_at": null
     *                }, {
     *                  "id": 4,
                        "work_description": "stari",
                        "developer_description": "primer",
                        "id_clients": 1,
                        "id_statuses": 1,
                        "created_at": "2021-04-23 14:31:42",
                        "updated_at": "2021-04-23 14:31:42",
                        "deleted_at": null
     *                }, {
     *                  "id": 5,
                        "work_description": "test work description",
                        "developer_description": "test developer description",
                        "id_clients": 1,
                        "id_statuses": 3,
                        "created_at": "2021-04-28 17:39:37",
                        "updated_at": "2021-04-28 17:39:37",
                        "deleted_at": null

     *                  }},
     *                @OA\Items(
     *                  @OA\Property(property="work_description", type="string"),
     *                  @OA\Property(property="developer_description", type="string"),
     *                  @OA\Property(property="id_clients", type="integer"),
     *                  @OA\Property(property="id_statuses", type="integer")
     *                ),
     *             ),
     * )
     *       )
     *     )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function get_assignments(int $id):JsonResponse
    {
        $assignments = DB::table('assignments')->where('id_clients', '=', $id)->get();
        return response()->json($assignments);
    }

    /**
     * @OA\Post(
     *      path="/assignments",
     *      operationId="storeAssignment",
     *      tags={"Assignments"},
     *      summary="Store new assignment",
     *      description="Returns assignment data",
     *      security={{ "apiAuth": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(property="work_description", type="string"),
     *                  @OA\Property(property="developer_description", type="string"),
     *                  @OA\Property(property="id_clients", type="integer"),
     *                  @OA\Property(property="id_statuses", type="integer")
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
     *                      @OA\Property(property="work_description", type="string"),
     *                      @OA\Property(property="developer_description", type="string"),
     *                      @OA\Property(property="id_clients", type="integer"),
     *                      @OA\Property(property="id_statuses", type="integer"),
     *                      example={
                                "work_description": "test work description",
                                "developer_description": "test developer description",
                                "id_clients": 1,
                                "id_statuses": 3,
                                "updated_at": "2021-04-28T17:39:37.000000Z",
                                "created_at": "2021-04-28T17:39:37.000000Z",
                                "id": 5
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
            'work_description' => 'required|string|max:200',
            'developer_description' => 'required|string|max:200',
            'id_clients' => 'required|integer',
            'id_statuses' => 'required|integer'
        ]);

        return response()->json(Assignment::create($validated), 201);
    }

    /**
     * @OA\Get(
     *      path="/assignments/{id}",
     *      operationId="getAssignmentById",
     *      tags={"Assignments"},
     *      summary="Get assignment information",
     *      description="Returns assignment data",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="Assignment id",
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
     *                      @OA\Property(property="work_description", type="string"),
     *                      @OA\Property(property="developer_description", type="string"),
     *                      @OA\Property(property="id_clients", type="integer"),
     *                      @OA\Property(property="id_statuses", type="integer"),
     *                      example={
     *                          "work_description": "test work description",
                                "developer_description": "test developer description",
                                "id_clients": 1,
                                "id_statuses": 3,
                                "updated_at": "2021-04-28T17:39:37.000000Z",
                                "created_at": "2021-04-28T17:39:37.000000Z",
                                "id": 5
     *                     }
     *                 )
     *             )
     *         }
     *       )
     * )
     * @param Assignment $assignment
     * @return JsonResponse
     */
    public function show(Assignment $assignment):JsonResponse
    {
        return response()->json($assignment);
    }

    /**
     * @OA\Put(
     *      path="/assignments/{id}",
     *      operationId="updateAssignment",
     *      tags={"Assignments"},
     *      summary="Update existing assignment",
     *      description="Returns updated assignment data",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="Assignment id",
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
     *                  @OA\Property(property="work_description", type="string"),
     *                  @OA\Property(property="developer_description", type="string"),
     *                  @OA\Property(property="id_clients", type="integer"),
     *                  @OA\Property(property="id_statuses", type="integer")
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
     *                      @OA\Property(property="work_description", type="string"),
     *                      @OA\Property(property="developer_description", type="string"),
     *                      @OA\Property(property="id_clients", type="integer"),
     *                      @OA\Property(property="id_statuses", type="integer"),
     *                      example=true
     *                 )
     *             )
     *         }
     *       )
     * )
     * @param Request $request
     * @param Assignment $assignment
     * @return JsonResponse
     */
    public function update(Request $request, Assignment $assignment):JsonResponse
    {
        $validated = $request->validate([
            'work_description' => 'required|string|max:200',
            'developer_description' => 'required|string|max:200',
            'id_clients' => 'required|integer',
            'id_statuses' => 'required|integer'
        ]);

        return response()->json($assignment->update($validated));
    }

    /**
     * @OA\Delete(
     *      path="/assignments/{id}",
     *      operationId="deleteAssignment",
     *      tags={"Assignments"},
     *      summary="Delete existing assignment",
     *      description="Deletes a record and returns no content",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="Assignment id",
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
     * @param Assignment $assignment
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Assignment $assignment):JsonResponse
    {
        return response()->json($assignment->delete(), 204);
    }
}
