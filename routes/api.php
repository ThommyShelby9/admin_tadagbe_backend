<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => ['api','with_api_key']], function () {
    Route::prefix('admissions')->group(function () {
            Route::get('/',             'Api\AdmissionApiController@index');
            Route::post('/store',             'Api\AdmissionApiController@store');
            Route::get('/get/{id}',             'Api\AdmissionApiController@show');
            Route::post('/update/{id}',             'Api\AdmissionApiController@update');
            Route::post('/delete/{id}',             'Api\AdmissionApiController@destroy');
            Route::post('/pay',             'Api\AdmissionApiController@adddPayment');
            Route::get('/get_payment/{id}',             'Api\AdmissionApiController@getPayment');
            Route::post('/update_payment/{id}',             'Api\AdmissionApiController@updatePayment');


        });
        Route::prefix('programmes')->group(function () {
            Route::get('/',             'Api\ProgrammeApiController@index');
            Route::post('/store',             'Api\ProgrammeApiController@store');
            Route::get('/get/{id}',             'Api\ProgrammeApiController@show');
            Route::post('/update/{id}',             'Api\ProgrammeApiController@update');
            Route::post('/delete/{id}',             'Api\ProgrammeApiController@destroy');

        });
        Route::prefix('articles')->group(function () {
            Route::get('/',             'Api\ArticleApiController@index');
            Route::post('/store',             'Api\ArticleApiController@store');
            Route::get('/get/{id}',             'Api\ArticleApiController@show');
            Route::post('/update/{id}',             'Api\ArticleApiController@update');
            Route::post('/delete/{id}',             'Api\ArticleApiController@destroy');

        });
});
//Route::middleware('api')->get('/admissions', function (Request $request) {
   // Route::resource('/admissions',        'Api/AdmissionApiController');
//  });
