<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IndexControllers;
use App\Http\Controllers\Admin\ProfileControllers;
use App\Http\Controllers\Admin\BuildingControllers;
use App\Http\Controllers\Admin\EventControllers;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\weatherControllers;
use App\Http\Controllers\Admin\LineNotifyController;


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



// เส้นทางหลักที่ไม่ใช้ Middleware ภาษา
Route::get('/', function () {
    return view('index'); // เปลี่ยนเส้นทางไปที่หน้า admin
})->name('home');

route::get('/send_notification', [LineNotifyController::class, 'sendWeatherToLineGroup']);

route::get('/language/{locale}', [LanguageController::class, 'switchLanguage'])->name('language.switch');

    Route::prefix('admin')->group(function () {
        Route::get('/', [BuildingControllers::class, 'index']);

        Route::get('/cannabis-plant', [IndexControllers::class, 'index']);
        Route::post('/print-qr-code', [IndexControllers::class, 'printQrCode']);
        Route::post('inset', [IndexControllers::class, 'insetInformation']);
        Route::get('delete/{id}', [IndexControllers::class, 'disableBasicInformation']);
        Route::get('search', [IndexControllers::class, 'search']);
        Route::get('showToken', [IndexControllers::class, 'showToken']);
        Route::get('weather', [weatherControllers::class, 'index']);

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
            Route::POST('/inset-for-qr-code', [EventControllers::class, 'insetEventByScanQrCode']);
            Route::get('/{id}', [EventControllers::class, 'showEventById']);
            Route::post('/inset', [EventControllers::class, 'insetEvent']);
        });
    });


