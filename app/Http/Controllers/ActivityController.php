<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request):JsonResponse
    {
        return response()->json(Activity::paginate($request->get('per_page', 15)));
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
            'title' => 'required|string|max:50',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'comment' => 'required|string',
            'id_assignments' => 'required|integer'
        ]);

        return response()->json(Activity::create($validated), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Activity $activity
     * @return JsonResponse
     */
    public function show(Activity $activity):JsonResponse
    {
        return response()->json($activity);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Activity $activity
     * @return JsonResponse
     */
    public function update(Request $request, Activity $activity):JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:50',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'comment' => 'required|string',
            'id_assignments' => 'required|integer'
        ]);

        return response()->json($activity->update($validated));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Activity $activity
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Activity $activity):JsonResponse
    {
        return response()->json($activity->delete(), 204);
    }
}
