<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IndexControllers;
use App\Http\Controllers\Admin\ProfileControllers;
use App\Http\Controllers\Admin\BuildingControllers;
use App\Http\Controllers\Admin\EventControllers;

use App\Http\Controllers\UserControllers;



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


Route::get('/', [UserControllers::class, 'index']);

Route::prefix('admin')->group(function () {
    Route::get('/', [BuildingControllers::class, 'index']);
    Route::get('/cannabis-plant', [IndexControllers::class, 'index']);
    Route::post('inset', [IndexControllers::class, 'insetInformation']);
    Route::get('delete/{id}', [IndexControllers::class, 'disableBasicInformation']);
    Route::get('search', [IndexControllers::class, 'search']);
    Route::get('showToken', [IndexControllers::class, 'showToken']);

    Route::prefix('profile')->group(function () {
        Route::get('{id}', [ProfileControllers::class, 'index']);
        Route::post('update/note/{id}', [ProfileControllers::class, 'updateBasicInformationNoteOnlyById']);
        Route::post('update/{id}', [ProfileControllers::class, 'update']);
        Route::post('insert-content-img', [ProfileControllers::class, 'insertContentImg']);
        Route::get('del-img/{id_img}', [ProfileControllers::class, 'delImgInProFile']);
        Route::get('get-img/{id_img}', [ProfileControllers::class, 'getImageByImageID']);
        Route::get('ajax/{id}', [ProfileControllers::class, 'ajaxGetBasicInformationById']);
    });
    Route::prefix('building')->group(function () {
        Route::get('/', [BuildingControllers::class, 'index']);
        Route::get('{id_building}', [BuildingControllers::class, 'getDataBuildingById']);
        Route::get('edit-building-each/{id}', [BuildingControllers::class, 'getDataBuildingEachDayById']);
        Route::post('edit-building-each/update/{id}', [BuildingControllers::class, 'upDateBuildingById']);
        Route::post('insert', [BuildingControllers::class, 'insertDataBuildingEachDay']);
    });

    Route::prefix('event')->group(function () {
        Route::get('/', [EventControllers::class, 'index']);
        Route::get('/{id}', [EventControllers::class, 'checkEventByIdInfo']);
        Route::get('/show', [EventControllers::class, 'show']);
        Route::post('/inset', [EventControllers::class, 'insetEvent']);
    });


});

