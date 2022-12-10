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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//TODO::register user
Route::post('/register', [AuthController::class, 'register']);
//TODO::login user
Route::post('/login', [AuthController::class, 'login']);
//TODO::logout user
Route::post('/logout', [AuthController::class, 'logout']);
////////////////////////Section File//////////////////////////
Route::resource('files', FileController::class);


/////////////////////////Section Group////////////////////////
Route::resource('groups', GroupController::class);


////////////////////Section Operation///////////////////////
Route::controller(OperationController::class)->group(/* ['prefix' => 'operations'], */function () {
    //TODO::add users to groups
    Route::post('addusers/{group}', 'addUsersToGroup');
    //TODO::add file to group
    Route::post('addfile/{file}', 'addFileToGroup');
});