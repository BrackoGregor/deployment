<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * @OA\Get(
     *      path="/contacts",
     *      operationId="getContactsList",
     *      tags={"Contacts"},
     *      summary="Get list of contacts",
     *      description="Returns list of contacts",
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
                        "email": "jnovak@gmail.com",
                        "phone": "041123321",
                        "id_client": 1,
                        "created_at": "2021-04-29T07:13:09.000000Z",
                        "updated_at": "2021-04-29T07:13:09.000000Z",
                        "deleted_at": null
     *                }, {
     *                  "id": 2,
                        "firstname": "zoran",
                        "lastname": "tezin",
                        "email": "zorantezin@gmail.com",
                        "phone": "070323567",
                        "id_client": 1,
                        "created_at": "2021-04-29T07:13:52.000000Z",
                        "updated_at": "2021-04-29T07:13:52.000000Z",
                        "deleted_at": null
     *                }},
     *                @OA\Items(
     *                  @OA\Property(property="firstname", type="string"),
     *                  @OA\Property(property="lastname", type="string"),
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="phone", type="string"),
     *                  @OA\Property(property="id_client", type="integer")
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
        return response()->json(Contact::paginate($request->get('per_page', 15)));
    }

    /**
     * @OA\Post(
     *      path="/contacts",
     *      operationId="storeContact",
     *      tags={"Contacts"},
     *      summary="Store new contact",
     *      description="Returns contact data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(property="firstname", type="string"),
     *                  @OA\Property(property="lastname", type="string"),
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="phone", type="string"),
     *                  @OA\Property(property="id_client", type="integer")
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
     *                      @OA\Property(property="email", type="string"),
     *                      @OA\Property(property="phone", type="string"),
     *                      @OA\Property(property="id_client", type="integer"),
     *                      example={
     *                          "id": 2,
                                "firstname": "zoran",
                                "lastname": "tezin",
                                "email": "zorantezin@gmail.com",
                                "phone": "070323567",
                                "id_client": 1,
                                "created_at": "2021-04-29T07:13:52.000000Z",
                                "updated_at": "2021-04-29T07:13:52.000000Z",
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
            'email' => 'required|string|email|max:80',
            'phone' => 'required|string|max:30',
            'id_client' => 'required|integer'
        ]);

        $contact = Contact::create($validated);

        return response()->json($contact, 201);

    }

    /**
     * @OA\Get(
     *      path="/contacts/{contact}",
     *      operationId="getContactById",
     *      tags={"Contacts"},
     *      summary="Get contact information",
     *      description="Returns contact data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Contact id",
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
     *                      @OA\Property(property="email", type="string"),
     *                      @OA\Property(property="phone", type="string"),
     *                      @OA\Property(property="id_client", type="integer"),
     *                      example={
     *                          "id": 1,
                                "firstname": "janez",
                                "lastname": "novak",
                                "email": "jnovak@gmail.com",
                                "phone": "041123321",
                                "id_client": 1,
                                "created_at": "2021-04-29T07:13:09.000000Z",
                                "updated_at": "2021-04-29T07:13:09.000000Z",
                                "deleted_at": null
     *                     }
     *                 )
     *             )
     *         }
     *       )
     * )
     * @param Contact $contact
     * @return JsonResponse
     */
    public function show(Contact $contact): JsonResponse
    {
        return response()->json($contact);
    }

    /**
     * @OA\Put(
     *      path="/contacts/{contact}",
     *      operationId="updateContact",
     *      tags={"Contacts"},
     *      summary="Update existing contact",
     *      description="Returns updated contact data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Contact id",
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
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="phone", type="string"),
     *                  @OA\Property(property="id_client", type="integer")
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
     *                      @OA\Property(property="email", type="string"),
     *                      @OA\Property(property="phone", type="string"),
     *                      @OA\Property(property="id_client", type="integer"),
     *                      example={
                                "id": 2,
                                "firstname": "franc",
                                "lastname": "soucek",
                                "email": "francsoucek@gmail.com",
                                "phone": "070323567",
                                "id_client": "1",
                                "created_at": "2021-04-29T07:13:52.000000Z",
                                "updated_at": "2021-04-29T07:20:02.000000Z",
                                "deleted_at": null
     *                      }
     *                 )
     *             )
     *         }
     *       )
     * )
     * @param Request $request
     * @param Contact $contact
     * @return JsonResponse
     */
    public function update(Request $request, Contact $contact): JsonResponse
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:80',
            'email' => 'required|string|email|max:80',
            'phone' => 'required|string|max:30',
            'id_client' => 'required|integer'
        ]);

        $contact->update($validated);

        return response()->json($contact, 200);

    }

    /**
     * @OA\Delete(
     *      path="/contacts/{contact}",
     *      operationId="deleteContact",
     *      tags={"Contacts"},
     *      summary="Delete existing contact",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Contact id",
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
     * @param Contact $contact
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Contact $contact): JsonResponse
    {
        $contact->delete();

        return response()->json(null, 204);
    }
}
