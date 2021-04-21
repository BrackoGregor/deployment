<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request):JsonResponse
    {
        return response()->json(Assignment::paginate($request->get('per_page', 15)));
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
            'work_description' => 'required|string|max:200',
            'developer_description' => 'required|string|max:200',
            'id_clients' => 'required|integer',
            'id_statuses' => 'required|integer'
        ]);

        return response()->json(Assignment::create($validated), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Assignment $assignment
     * @return JsonResponse
     */
    public function show(Assignment $assignment):JsonResponse
    {
        return response()->json($assignment);
    }

    /**
     * Update the specified resource in storage.
     *
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
     * Remove the specified resource from storage.
     *
     * @param Assignment $assignment
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Assignment $assignment):JsonResponse
    {
        return response()->json($assignment->delete(), 204);
    }
}
