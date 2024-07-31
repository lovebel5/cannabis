<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IndexControllers;
use App\Http\Controllers\Admin\ProfileControllers;
use App\Http\Controllers\Admin\BuildingControllers;
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
    Route::get('profile/{id}', [ProfileControllers::class, 'index']);
    Route::post('profile/update/note/{id}', [ProfileControllers::class, 'updateBasicInformationNoteOnlyById']);
    Route::post('profile/update/{id}', [ProfileControllers::class, 'update']);
    Route::post('profile/insert-content-img', [ProfileControllers::class, 'insertContentImg']);
    Route::get('profile/del-img/{id_img}', [ProfileControllers::class, 'delImgInProFile']);
    Route::get('profile/get-img/{id_img}', [ProfileControllers::class, 'getImageByImageID']);
    Route::get('profile/ajax/{id}', [ProfileControllers::class, 'ajaxGetBasicInformationById']);
    Route::get('showToken', [IndexControllers::class, 'showToken']);
    Route::get('building', [BuildingControllers::class, 'index']);
    Route::get('building/{id_building}', [BuildingControllers::class, 'getDataBuildingById']);
    Route::get('building/edit-building-each/{id}', [BuildingControllers::class, 'getDataBuildingEachDayById']);
    Route::post('building/edit-building-each/update/{id}', [BuildingControllers::class, 'upDateBuildingById']);
    Route::post('building/insert', [BuildingControllers::class, 'insertDataBuildingEachDay']);

});

