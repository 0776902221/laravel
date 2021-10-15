   
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SanasaGeneralController;
use App\Http\Controllers\SanasaGeneralDownloadController;
use App\Http\Controllers\Auth\AuthController;

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

//Route::middleware('auth:api')->group(function () {



Route::get('SanasaGenerals/search/{from_date}/{to_date}',[SanasaGeneralDownloadController::class,'search']);
Route::get('SanasaGenerals/view/{from_date}/{to_date}',[SanasaGeneralDownloadController::class,'view']);
Route::get('SanasaGenerals/confirm/{from_date}/{to_date}',[SanasaGeneralDownloadController::class,'confirm']);
Route::get('SanasaGenerals/pdf/{download_id}',[SanasaGeneralDownloadController::class,'createPDF']);
Route::get('SanasaGenerals/xls/{download_id}',[SanasaGeneralDownloadController::class,'createXLS']);
Route::get('SanasaGenerals/csv/{download_id}',[SanasaGeneralDownloadController::class,'createCSV']);
Route::get('SanasaGenerals/download',[SanasaGeneralDownloadController::class,'index']);
Route::get('SanasaGenerals/download/{id}',[SanasaGeneralDownloadController::class,'show']);
Route::get('SanasaGenerals/missed',[SanasaGeneralDownloadController::class,'missed']);
Route::get('SanasaGenerals/isMissed',[SanasaGeneralDownloadController::class,'isMissed']);
Route::get('SanasaGenerals/apiData',[SanasaGeneralDownloadController::class,'apidata']);

Route::get('SanasaGenerals',[SanasaGeneralController::class,'index']);
Route::get('SanasaGenerals/Create',[SanasaGeneralController::class,'create']);
Route::get('SanasaGenerals/{SanasaGeneral}',[SanasaGeneralController::class,'show']);
Route::post('SanasaGenerals',[SanasaGeneralController::class,'store']);
Route::put('SanasaGenerals/{SanasaGeneral}',[SanasaGeneralController::class,'update']);
Route::delete('SanasaGenerals/{SanasaGeneral}',[SanasaGeneralController::class,'delete']);
//});