<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * @OA\Get(
     *      path="/clients",
     *      operationId="getClientsList",
     *      tags={"Clients"},
     *      summary="Get list of clients",
     *      description="Returns list of clients",
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
                        "name": "test123",
                        "address": "12345",
                        "postcode": "2000",
                        "city": "Maribor",
                        "country": "Slovenija",
                        "created_at": "2021-04-20T10:19:05.000000Z",
                        "updated_at": "2021-04-21T10:40:39.000000Z",
                        "deleted_at": null
     *                }, {
     *                  "id": 2,
                        "name": "firma",
                        "address": "primer",
                        "postcode": "2000",
                        "city": "Maribor",
                        "country": "Slovenija",
                        "created_at": "2021-04-23T14:30:42.000000Z",
                        "updated_at": "2021-04-23T14:30:42.000000Z",
                        "deleted_at": null
     *                }},
     *                @OA\Items(
     *                  @OA\Property(property="name", type="string"),
     *                  @OA\Property(property="address", type="string"),
     *                  @OA\Property(property="postcode", type="string"),
     *                  @OA\Property(property="city", type="string"),
     *                  @OA\Property(property="country", type="string")
     *                ),
     *             ),
     * )
     *       )
     *     )
     * @param $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        //return response()->json(Client::all());
        //return response()->json(Client::paginate());
        return response()->json(Client::paginate($request->get('per_page', 15)));
    }


    /**
     * @OA\Post(
     *      path="/clients",
     *      operationId="storeClient",
     *      tags={"Clients"},
     *      summary="Store new client",
     *      description="Returns client data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(property="name", type="string"),
     *                  @OA\Property(property="address", type="string"),
     *                  @OA\Property(property="postcode", type="string"),
     *                  @OA\Property(property="city", type="string"),
     *                  @OA\Property(property="country", type="string")
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
     *                      @OA\Property(property="address", type="string"),
     *                      @OA\Property(property="postcode", type="string"),
     *                      @OA\Property(property="city", type="string"),
     *                      @OA\Property(property="country", type="string"),
     *                      example={
     *                          "id": 2,
                                "name": "podjetje d.o.o.",
                                "address": "počehova",
                                "postcode": "2000",
                                "city": "Maribor",
                                "country": "Slovenija",
                                "created_at": "2021-04-23T14:30:42.000000Z",
                                "updated_at": "2021-04-23T14:30:42.000000Z",
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
            'name' => 'required|string|max:100',
            'address' => 'required|string|max:100',
            'postcode' => 'required|string|max:10',
            'city' => 'required|string|max:50',
            'country' => 'required|string|max:50'
        ]);

        $client = Client::create($validated);

        return response()->json($client, 201);

    }

    /**
     * @OA\Get(
     *      path="/clients/{client}",
     *      operationId="getClientById",
     *      tags={"Clients"},
     *      summary="Get client information",
     *      description="Returns client data",
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
     *          content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                      @OA\Property(property="name", type="string"),
     *                      @OA\Property(property="address", type="string"),
     *                      @OA\Property(property="postcode", type="string"),
     *                      @OA\Property(property="city", type="string"),
     *                      @OA\Property(property="country", type="string"),
     *                      example={
     *                          "id": 3,
                                "name": "nova",
                                "address": "primer",
                                "postcode": "2000",
                                "city": "Maribor",
                                "country": "Slovenija",
                                "created_at": "2021-04-23T14:30:45.000000Z",
                                "updated_at": "2021-04-23T14:30:45.000000Z",
                                "deleted_at": null
     *                     }
     *                 )
     *             )
     *         }
     *       )
     * )
     * @param Client $client
     * @return JsonResponse
     */
    public function show(Client $client): JsonResponse
    {
        return response()->json($client);
    }


    /**
     * @OA\Put(
     *      path="/clients/{client}",
     *      operationId="updateClient",
     *      tags={"Clients"},
     *      summary="Update existing client",
     *      description="Returns updated client data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Client id",
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
     *                  @OA\Property(property="name", type="string"),
     *                  @OA\Property(property="address", type="string"),
     *                  @OA\Property(property="postcode", type="string"),
     *                  @OA\Property(property="city", type="string"),
     *                  @OA\Property(property="country", type="string")
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
     *                      @OA\Property(property="address", type="string"),
     *                      @OA\Property(property="postcode", type="string"),
     *                      @OA\Property(property="city", type="string"),
     *                      @OA\Property(property="country", type="string"),
     *                      example={
                                "id": 2,
                                "name": "solve-x",
                                "address": "počehova",
                                "postcode": "2000",
                                "city": "Maribor",
                                "country": "Slovenija",
                                "created_at": "2021-04-23T14:30:42.000000Z",
                                "updated_at": "2021-04-29T07:07:40.000000Z",
                                "deleted_at": null
     *                      }
     *                 )
     *             )
     *         }
     *       )
     * )
     * @param Request $request
     * @param Client $client
     * @return JsonResponse
     */
    public function update(Request $request, Client $client): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'required|string|max:100',
            'postcode' => 'required|string|max:10',
            'city' => 'required|string|max:50',
            'country' => 'required|string|max:50'
        ]);

        $client->update($validated);

        return response()->json($client, 200);

    }

    /**
     * @OA\Delete(
     *      path="/clients/{client}",
     *      operationId="deleteClient",
     *      tags={"Clients"},
     *      summary="Delete existing client",
     *      description="Deletes a record and returns no content",
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
     *          response=204,
     *          description="No content"
     *       )
     * )
     * @param Client $client
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Client $client): JsonResponse
    {
        $client->delete();

        return response()->json(null, 204);
    }
}
