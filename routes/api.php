<?php

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


Route::prefix('v1')->group(function () {

    Route::namespace('api\v1')->middleware('api')->group(function () {

        Route::post('registerUser', 'UserController@register');
        Route::post('loginUser', 'UserController@login');
        Route::post('resetPassword', 'UserController@resetPassword');
        Route::post('resetPasswordGetCode', 'UserController@resetPasswordGetCode');
        Route::post('resetPasswordNewPass', 'UserController@resetPasswordNewPass');

        Route::middleware('auth:api')->group(function () {
            // Route::get('getAllTours','TourController@getAllTours');
            Route::get('getTours', 'TourController@index');
            Route::post('searchCities', 'SearchCityController@search');
            Route::get('showTourDetails', 'TourDetailsController@showTourDetails');
            Route::get('getAbout', 'siteData@about');
            Route::get('getRules', 'siteData@rules');
            Route::post('storeTicketFromAndroid', 'siteData@storeTicket');
            Route::get('favToursList', 'TourController@favTours');
            Route::get('internalToursList', 'TourController@internalTours');
            Route::get('foreignToursList', 'TourController@foreignTours');
            Route::get('indoorsToursList', 'TourController@indoorsTours');
            Route::get('momentToursList', 'TourController@momentTours');
            Route::get('searchTours', 'TourController@searchTours');
            Route::get('agenciesList', 'siteData@agencyList');
            Route::post('sendNotifyFromUser', 'UserController@sendNotify');
        });
        Route::post('searchCities', 'SearchCityController@search');
        Route::get('checkAndroidVerion', 'AppVersionController@androidVersion');


        Route::namespace('gasht')->group(function () {
            Route::middleware('auth:api')->group(function () {
                Route::prefix('/gasht')-> group(function () {
                    Route::get('/allGasht', 'GashtController@allGashts')->name('allGasht');
                    Route::get('/searchCities', 'GashtController@searchCities');
                    Route::get('/searchGashts', 'GashtController@searchGashts')->name('searchGasht');
                    Route::get('/singleGasht', 'GashtController@singleGasht')->name('singleGasht');
                    Route::get('/checkSelectRequest', 'GashtController@checkSelectRequest')->name('checkSelectRequest');
                    Route::get('/buyReserve', 'GashtController@buyReserve')->name('buyReserve');
                    Route::post('/buyResponse', 'GashtController@buyResponse')->name('buyResponse');
                });

            });
        });



    });


    Route::namespace('api\v1\gasht')->group(function () {
        Route::middleware('AuthWebService')->group(function () {
            Route::prefix('/gasht')-> group(function () {
                Route::get('/allGasht', 'GashtController@allGashts')->name('allGasht');
                Route::get('/searchCities', 'GashtController@searchCities');
                Route::get('/searchGashts', 'GashtController@searchGashts')->name('searchGasht');
                Route::get('/singleGasht', 'GashtController@singleGasht')->name('singleGasht');
                Route::get('/checkSelectRequest', 'GashtController@checkSelectRequest')->name('checkSelectRequest');
                Route::get('/buyReserve', 'GashtController@buyReserve')->name('buyReserve');
                Route::post('/buyResponse', 'GashtController@buyResponse')->name('buyResponse');
            });

        });
    });


    Route::namespace('api\v1\transfer')->middleware('AuthWebService')->group(function () {
        Route::prefix('/transfer')->group(function () {
            Route::get('/allTransfers', 'TransferController@allTransfers')->name('allTransfers');
            Route::get('/searchTransfers', 'TransferController@searchTransfers')->name('searchTransfers');
            Route::get('/singleTransfer', 'TransferController@singleTransfer')->name('singleTransfer');
        });
    });

    Route::namespace('api\v1\tour')->middleware('AuthWebService')->group(function () {
        Route::prefix('/tour')->group(function () {
            Route::get('/allTours', 'TourController@getAllTours')->name('api.allTours');
            Route::get('/tourDetails', 'TourController@tourDetails')->name('api.tourDetails');
            Route::get('/searchTour', 'TourController@searchTour')->name('api.searchTour');
        });
    });


});

