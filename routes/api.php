<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\FileController;
use App\Http\Controllers\Api\V1\GroupController;
use App\Http\Controllers\Api\V1\OperationController;
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




////////////////////////Section User///////////////////////////////////////

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);





////////////////////////Section File//////////////////////////
Route::resource('files', FileController::class);
//TODO::عرض الفايلات التي يملكها اليوزر
Route::get('files/user/{user}', [FileController::class, 'showUserFiles']);
//TODO::create a public group

/////////////////////////Section Group////////////////////////
Route::resource('groups', GroupController::class);
//TODO::عرض المحموعات التي يملكها اليوزر
Route::get('groups/user/{user}', [GroupController::class, 'showUserGroups']);
//TODO::create a public group
Route::get('public', [GroupController::class, 'createPublicGroup']);




////////////////////Section Operation///////////////////////
Route::controller(OperationController::class)->group(/* ['prefix' => 'operations'], */function () {
    //TODO::add users to groups
    Route::post('addusers/{group}',   'addUsersToGroup');
    //TODO::remove users from group
    Route::post('removeuser/{group}', 'removeUsersFromGroup');
    //TODO::add file to group
    Route::post('addfile/{file}', 'addFileToGroup');
    //TODO::remove file from group
    Route::post('groups/removefile', 'removeFileFromGroup');
});