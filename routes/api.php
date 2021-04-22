<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserAssignmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function() {

    Route::post('users', [UserController::class, 'store']);

    Route::group(['middleware' => ['auth:api']], function() {
        Route::apiResources([
            'clients' => ClientController::class,
            'contacts' => ContactController::class,
            'roles' => UserRoleController::class,
            'activities' => ActivityController::class,
            'assignments' => AssignmentController::class,
            'statuses' => StatusController::class,
            'userAssignments' => UserAssignmentController::class
        ]);

        Route::apiResource('users', UserController::class)->except('store');
    });

});

