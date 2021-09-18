<?php

use App\Http\Controllers\Admin\BusinessController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthenticationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LandingPageController::class, 'viewLandingPage']);


Route::get('/admin/{dashboard?}', [DashboardController::class, 'index'])
    ->where('dashboard', 'dashboard|home')
    ->name('dashboard')->middleware('admin');

Route::prefix('/admin')->group(function() {

    Route::post('/loginpost', [AuthenticationController::class, 'loginpost'])
        ->name('loginpost');

    Route::get('/logout', [AuthenticationController::class, 'logout'])
        ->name('logout');

    Route::get('/businesseslist', [BusinessController::class, 'businessesList'])
        ->name('businesses-List')->middleware('admin');

    Route::get('/getBusinessData', [BusinessController::class, 'getBusinessData'])
        ->name('businesses-items');

    Route::post('/deletebusiness', [BusinessController::class, 'deleteBusiness'])
        ->name('delete-business')->middleware('admin');

    Route::get('/editbusiness/{id}', [BusinessController::class, 'editBusiness'])
        ->name('edit-business')->middleware('admin');

    Route::post('/updatebusiness/{id}', [BusinessController::class, 'updateBusiness'])
        ->name('update-business')->middleware('admin');

    Route::get('/archivebusiness/{id}', [BusinessController::class, 'archiveBusiness'])
        ->name('archive-business')->middleware('admin');

    Route::get('/unarchivebusiness/{id}', [BusinessController::class, 'unarchiveBusiness'])
        ->name('unarchive-business')->middleware('admin');

    Route::get('/searchbusinesses', [BusinessController::class, 'searchBusiness'])
        ->name('search-businesses')->middleware('admin');
});

Route::get('/admin/login', function() {
    return view('admin.login');
})->name('admin.login');
