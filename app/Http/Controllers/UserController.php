<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *      path="/users",
     *      operationId="getUsersList",
     *      tags={"Users"},
     *      summary="Get list of users",
     *      description="Returns list of users",
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
                        "firstname": "janez",
                        "lastname": "novak",
                        "username": "janeznovak",
                        "email": "janez.novak@gmail.com",
                        "id_users_roles": 1,
                        "created_at": "2021-04-20T12:17:23.000000Z",
                        "updated_at": "2021-04-20T12:17:23.000000Z",
                        "deleted_at": "0000-00-00 00:00:00"
     *                }, {
     *                  "id": 2,
                        "firstname": "test",
                        "lastname": "test",
                        "username": "test12345",
                        "email": "test.test@gmail.com",
                        "id_users_roles": 1,
                        "created_at": "2021-04-21T10:19:09.000000Z",
                        "updated_at": "2021-04-21T10:19:09.000000Z",
                        "deleted_at": null
     *                }},
     *                @OA\Items(
     *                  @OA\Property(property="firstname", type="string"),
     *                  @OA\Property(property="lastname", type="string"),
     *                  @OA\Property(property="username", type="string"),
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="password", type="string"),
     *                  @OA\Property(property="id_users_roles", type="integer")
     *                ),
     *             ),
     * )
     *       )
     *     )
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json(User::paginate($request->get('per_page', 15)));
    }

    /**
     * @OA\Post(
     *      path="/users",
     *      operationId="storeUser",
     *      tags={"Users"},
     *      summary="Store new user",
     *      description="Returns user data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(property="firstname", type="string"),
     *                  @OA\Property(property="lastname", type="string"),
     *                  @OA\Property(property="username", type="string"),
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="password", type="string"),
     *                  @OA\Property(property="id_users_roles", type="integer")
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
     *                      @OA\Property(property="firstname", type="string"),
     *                      @OA\Property(property="lastname", type="string"),
     *                      @OA\Property(property="username", type="string"),
     *                      @OA\Property(property="email", type="string"),
     *                      @OA\Property(property="password", type="string"),
     *                      @OA\Property(property="id_users_roles", type="integer"),
     *                      example={
     *                          "id": 2,
                                "firstname": "test",
                                "lastname": "test",
                                "username": "test12345",
                                "email": "test.test@gmail.com",
                                "id_users_roles": 1,
                                "created_at": "2021-04-21T10:19:09.000000Z",
                                "updated_at": "2021-04-21T10:19:09.000000Z",
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
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:80',
            'username' => 'required|string|unique:users|max:45',
            'email' => 'required|string|email|unique:users|max:80',
            'password' => 'required|string|min:6|max:150',
            'id_users_roles' => 'required|integer'
        ]);

        $user = User::create($validated);

        return response()->json($user, 201);

    }

    /**
     * @OA\Get(
     *      path="/users/{user}",
     *      operationId="getUserById",
     *      tags={"Users"},
     *      summary="Get user information",
     *      description="Returns user data",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
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
     *                      @OA\Property(property="firstname", type="string"),
     *                      @OA\Property(property="lastname", type="string"),
     *                      @OA\Property(property="username", type="string"),
     *                      @OA\Property(property="email", type="string"),
     *                      @OA\Property(property="password", type="string"),
     *                      @OA\Property(property="id_users_roles", type="integer"),
     *                      example={
     *                          "id": 1,
                                "firstname": "janez",
                                "lastname": "novak",
                                "username": "janeznovak",
                                "email": "janez.novak@gmail.com",
                                "id_users_roles": 1,
                                "created_at": "2021-04-20T12:17:23.000000Z",
                                "updated_at": "2021-04-20T12:17:23.000000Z",
                                "deleted_at": "0000-00-00 00:00:00"
     *                     }
     *                 )
     *             )
     *         }
     *       )
     * )
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    /**
     * @OA\Put(
     *      path="/users/{user}",
     *      operationId="updateUser",
     *      tags={"Users"},
     *      summary="Update existing user",
     *      description="Returns updated user data",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
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
     *                  @OA\Property(property="firstname", type="string"),
     *                  @OA\Property(property="lastname", type="string"),
     *                  @OA\Property(property="username", type="string"),
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="password", type="string"),
     *                  @OA\Property(property="id_users_roles", type="integer")
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
     *                      @OA\Property(property="firstname", type="string"),
     *                      @OA\Property(property="lastname", type="string"),
     *                      @OA\Property(property="username", type="string"),
     *                      @OA\Property(property="email", type="string"),
     *                      @OA\Property(property="password", type="string"),
     *                      @OA\Property(property="id_users_roles", type="integer"),
     *                      example={
                                "id": 3,
                                "firstname": "updateIme",
                                "lastname": "updatePriimek",
                                "username": "update",
                                "email": "ime1.test@gmail.com",
                                "id_users_roles": 1,
                                "created_at": "2021-04-21T10:32:35.000000Z",
                                "updated_at": "2021-04-22T07:55:54.000000Z",
                                "deleted_at": null
     *                      }
     *                 )
     *             )
     *         }
     *       )
     * )
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:80',
            'username' => 'required|string|unique:users|max:45',
            'email' => 'string|email|unique:users|max:80',
            'password' => 'string|min:6|max:150',
            'id_users_roles' => 'required|integer'
        ]);

        $user->update($validated);

        return response()->json($user, 200);

    }

    /**
     * @OA\Delete(
     *      path="/users/{user}",
     *      operationId="deleteUser",
     *      tags={"Users"},
     *      summary="Delete existing user",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
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
     * @param User $user
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json(null, 204);
    }
}
