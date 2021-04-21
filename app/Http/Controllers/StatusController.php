<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request):JsonResponse
    {
        return response()->json(Status::paginate($request->get('per_page', 15)));
    }

    /**
     * Store a newly created resource in storage.
     *
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
     * Display the specified resource.
     *
     * @param Status $status
     * @return JsonResponse
     */
    public function show(Status $status):JsonResponse
    {
        return response()->json($status);
    }

    /**
     * Update the specified resource in storage.
     *
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
     * Remove the specified resource from storage.
     *
     * @param Status $status
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Status $status):JsonResponse
    {
        return response()->json($status->delete(), 204);
    }
}
