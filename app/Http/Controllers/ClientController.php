<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
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
     * Store a newly created resource in storage.
     *
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
     * Display the specified resource.
     *
     * @param Client $client
     * @return JsonResponse
     */
    public function show(Client $client): JsonResponse
    {
        return response()->json($client);
    }


    /**
     * Update the specified resource in storage.
     *
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
     * Remove the specified resource from storage.
     *
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
