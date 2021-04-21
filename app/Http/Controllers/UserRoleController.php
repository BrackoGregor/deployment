<?php

namespace App\Http\Controllers;

use App\Models\User_Role;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json(User_Role::paginate($request->get('per_page', 15)));
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
            'role' => 'required|string|max:50'
        ]);

        $role = User_Role::create($validated);

        return response()->json($role, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param User_Role $role
     * @return JsonResponse
     */
    public function show(User_Role $role): JsonResponse
    {
        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User_Role $role
     * @return JsonResponse
     */
    public function update(Request $request, User_Role $role): JsonResponse
    {
        $validated = $request->validate([
            'role' => 'required|string|max:50'
        ]);

        $role->update($validated);

        return response()->json($role, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User_Role $role
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(User_Role $role): JsonResponse
    {
        $role->delete();

        return response()->json(null, 204);
    }
}
