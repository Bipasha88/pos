<?php

use App\Http\Controllers\Prouct\ProductController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\User\BranchController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\EmployeeController;

use App\Http\Controllers\User\VendorController;
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


Route::post('register', [TokenController::class, 'register']);
Route::post('login', [TokenController::class, 'authenticate']);

Route::prefix('business')->middleware('jwt.verify')->group(function () {
    Route::get('list', [EmployeeController::class, 'getBusinessList']);
    Route::apiResource('employee', EmployeeController::class);
    Route::apiResource('branch', BranchController::class);
    Route::apiResource('product', ProductController::class);
    Route::get('getAllCategories', [ProductController::class, 'getAllCategories']);
    Route::get('getOwenedBusiness', [ProductController::class, 'getOwenedBusiness']);
    Route::apiResource('vendor', VendorController::class);
    Route::get('brancheslist', [VendorController::class,'getOwnedBranches']);
    Route::apiResource('category', CategoryController::class);
});
