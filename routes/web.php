<?php

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

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Morilog\Jalali\Jalalian;
use App\Package;
use App\Agency;
use App\Post;

Route::get('/', 'SiteController@index');

Auth::routes(['verify' => true]);
Route::get('logout', 'Auth\LoginController@logout');
Route::get('administrator', 'Auth\LoginController@adminForm');
Route::prefix('admin')->name('admin.')->namespace('admin')->middleware('admin')->group(function () {
    Route::resource('/', 'DashboardController');
    Route::resource('Service', 'ServiceController');
    Route::resource('Package', 'PackageController');

    Route::get('lisCity', 'PackageController@lisCity');
    Route::get('lisCountries', 'PackageController@listCountries');
    Route::get('lisContinents', 'PackageController@listContinents');
    Route::get('listTours', 'PackageController@listTours');


    Route::get('listAgencies', 'PackageController@listAgencies');
    Route::post('uploadImgPackage/{tmptime}', 'PackageController@uploadImg');
    Route::post('DeleteImgPackage', 'PackageController@deletimg');
    Route::post('MainUploadImg/{id}', 'PackageController@MainUploadImg');
    Route::post('MainDeleteImg', 'PackageController@MainDeleteImg');
    Route::resource('Permission', 'PermissionController');
    Route::resource('Agency', 'AgencyController');
    Route::resource('TourManagement', 'TourManagementController');

    Route::get('siteAbout', 'SiteDataController@editAbout')->name('adminAbout');
    Route::post('siteAbout/update', 'SiteDataController@updateAbout')->name('adminAboutUpdate');

    Route::get('siteContact', 'SiteDataController@editContact')->name('adminContact');
    Route::post('siteContact/update', 'SiteDataController@updateContact')->name('adminContactUpdate');

    Route::get('siteRules', 'SiteDataController@editRules')->name('adminRules');
    Route::post('siteRules/update', 'SiteDataController@updateRules')->name('adminRulesUpdate');

    Route::get('showTickets', 'SiteDataController@showTickets')->name('showsTicket');

    Route::get('editPassword', 'AgencyController@editUserPassword')->name('editPassword');
    Route::post('updatePassword', 'AgencyController@updateUserPassword')->name('updateUserPasswords');

    Route::get('editCurrencies', 'CurrencyController@edit')->name('editCurrencies');
    Route::post('updateCurrencies', 'CurrencyController@update')->name('updateCurrencies');

    Route::get('locationRelates', 'CityRelateController@edit')->name('locationRelates');
    Route::post('locationRelatePost', 'CityRelateController@update')->name('locationRelatesUpdate');

    Route::get('showCityForm', 'SiteDataController@showCityForm')->name('showCityForms');
    Route::post('storeNewCity', 'SiteDataController@storeNewCity')->name('storeNewCitys');

    Route::get('showNotificationList', 'SiteDataController@NotificationList')->name('showNotificationList');
    Route::post('checkHasNotifications', 'SiteRegisterAgencyDataController@checkHasNotifications')->name('checkHasNotifications');


    Route::resource('FavoriteTours', 'FavoriteToursController');

    Route::get('createPost', 'SiteDataController@createPost')->name('createPost');
    Route::post('storePost', 'SiteDataController@storePost')->name('post.store');
    Route::get('listPost', 'SiteDataController@listPost')->name('listPost');
    Route::get('editPost/{id}', 'SiteDataController@editPost')->name('editPost');
    Route::post('updatePost/{id}', 'SiteDataController@updatePost')->name('post.update');
    Route::delete('deletePost/{id}', 'SiteDataController@deletePost')->name('deletePost');
    Route::post('uploadImage', 'SiteDataController@uploadImage')->name('post.uploadImage');

    Route::get('createVideo', 'SiteDataController@createVideo')->name('createVideo');
    Route::post('storeVideo', 'SiteDataController@storeVideo')->name('video.store');
    Route::get('listVideo', 'SiteDataController@listVideo')->name('listVideo');
    Route::get('editVideo/{id}', 'SiteDataController@editVideo')->name('editVideo');
    Route::post('updateVideo/{id}', 'SiteDataController@updateVideo')->name('video.update');
    Route::delete('deleteVideo/{id}', 'SiteDataController@deleteVideo')->name('deleteVideo');

    Route::get('/createGasht', 'GashtController@create')->name('createGasht');
    Route::post('/storeGasht', 'GashtController@store')->name('storeGasht');
    Route::get('/listGasht', 'GashtController@index')->name('listGasht');
    Route::delete('/deleteGasht', 'GashtController@destroy')->name('deleteGasth');
    Route::get('/editGasht/{gasht}', 'GashtController@edit')->name('editGasht');
    Route::post('/updateGasht/{id}/', 'GashtController@update')->name('updateGasht');
    Route::get('/listGashtSells','GashtController@sellList')->name('listGashtSell');
    Route::post('/deletecheck','GashtController@deletecheck')->name('deletecheck');
    Route::post('/activestatus','GashtController@activestatus')->name('activestatus');
    Route::post('/unactivestatus','GashtController@unactivestatus')->name('unactivestatus');

    Route::get('/createTransfer', 'TransferController@create')->name('createTransfer');
    Route::post('/storeTransfer', 'TransferController@store')->name('storeTransfer');
    Route::get('/listTransfer', 'TransferController@index')->name('listTransfer');
    Route::get('/editTransfer/{transfer}', 'TransferController@edit')->name('editTransfer');
    Route::post('/updatetTransfer/{id}/', 'TransferController@update')->name('updateTransfer');



    Route::get("/create",'TravelerController@create')->name('Traveler.create');
    Route::get("/listTraveler",'TravelerController@index')->name('Traveler.index');
    Route::post("/storeTraveler",'TravelerController@store')->name('Traveler.store');
    Route::get("/editTraveler/{id}",'TravelerController@edit')->name('Traveler.edit');
    Route::delete("/editTraveler/{id}",'TravelerController@destroy')->name('Traveler.destroy');


});

Auth::routes();


Route::get('flights', 'FlightController@index');
Route::get('/flight', 'FlightsController@flight');

Route::get('/statuscronjob','GashtController@statusjob');

// Route::get('textUrl', function (\Illuminate\Http\Request $r) {
//     dd('a');
// });

Route::get('Tours/{type?}/{value?}', 'TourController@search');
Route::post('Tours/{type?}/{value?}', 'TourController@filter');
Route::get('lisCity', 'TourController@lisCity');
Route::get('Tour/{id}/{city?}', 'TourController@details')->name('tourSinglePage');
Route::get('RegisterAgency', 'TourController@createAgency');
Route::post('registerAgencyPost', 'TourController@createAgencyPost');
Route::get('RegisterTraveler', 'TourController@createTraveler');
//Route::get('RegisterTraveler', 'TourController@addagancy');
Route::post('registerTravelerPost', 'TourController@createTravelerPost')->name('storeTraveler');

//Route::get('internalTours','TourController@internalTours');
//Route::get('foreignTours','TourController@foreignTours');

//Route::get("/TourController@agenciesList");


Route::get('/about', 'TourController@aboutPage');
Route::get('/contact', 'TourController@contactPage');
Route::get('/rules', 'TourController@rulesPage');


Route::get('/searchAgency/{search?}', 'TourController@searchAgency')->name('siteSearchAgensies');

Route::post('postTicketSite', 'TourController@sendTicket')->name('sendTicket');

Route::post('/favTourAdd', 'TourController@favTourAdd');
Route::post('/favTourRemove', 'TourController@favTourRemove');
Route::get('/favTourList', 'TourController@favTourList');

Route::get('/removeFilterCityDate', 'TourController@removeFilterCityDates');

Route::get('/blog', 'BlogController@index')->name('allPosts');
Route::get('/blog/{id}/{title?}', 'BlogController@show')->name('showPost');

Route::get('/gashts', 'GashtController@gashtList');
Route::get('/transfers', 'TransferController@transferList');


//Route::get('/sitemap', function () {
//    $sitemap = App::make('sitemap');
//    $sitemap->add(URL::to('/'), date('Y-m-d H:i:s'), '1.0', 'daily');
//
//    $agencies = Agency::where('status', '1')->pluck('id')->toArray();
//    $packages = Package::where('start_in', '>=', date(Carbon::now()->format('Y-m-d')))
//        ->where('status', '1')->latest()->limit(150)->get();
//
//    $posts = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(150)->get();
//
//    dd($posts);
//
//    foreach ($posts as $row => $value) {
////
////        // $images[] = array(
////        //     'url' => URL::to('/') . "/storage/blog/" . $value->image_thumb,
////        //     'title' => $value->title,
////        //     'caption' => $value->title
////        // );
////
////        $sitemap->add(URL::route("showPost", ['id' => $value->id, 'city' => $value->title]), $value->created_at, '1.0', 'daily');
////    }
////
////    foreach ($packages as $row => $value)
////    {
////
////        $images[] = array(
////            'url' => URL::to('/') . "/storage/thump/" . $value->imageThumb,
////            'title' => $value->title,
////            'caption' => $value->title
////        );
////
////        $sitemap->add(URL::route("tourSinglePage", ['id' => $value->id, 'city' => $value->title]), $value->created_at, '1.0', 'daily', $images);
////    }
//
//    return $sitemap->render('xml');
//});

