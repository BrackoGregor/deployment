<?php

namespace App\Http\Controllers;

use App\Models\User_Assignment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request):JsonResponse
    {
        return response()->json(User_Assignment::paginate($request->get('per_page', 15)));
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
            'id_users' => 'required|integer',
            'id_assignments' => 'required|integer'
        ]);

        return response()->json(User_Assignment::create($validated), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param User_Assignment $userAssignment
     * @return JsonResponse
     */
    public function show(User_Assignment $userAssignment):JsonResponse
    {
        return response()->json($userAssignment);
    }

    /**
     * Update the specified resource in storage.
     *
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
     * Remove the specified resource from storage.
     *
     * @param User_Assignment $userAssignment
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(User_Assignment $userAssignment):JsonResponse
    {
        return response()->json($userAssignment->delete(), 204);
    }
}
