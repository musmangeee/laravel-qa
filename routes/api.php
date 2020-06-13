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
Route::post('signup','UserController@userSignup');
Route::post('activate_account','UserController@activateAccount');
Route::post('signin','UserController@userSignin');
Route::post('forgot_password','UserController@forgotPassword');
Route::post('reset_password','UserController@resetPassword');
Route::get('lottery_price','LotteryPriceController@lotteryPrice');

Route::group(['prefix' => 'auth'], function () {
    Route::post('login','AuthController@authenticate');
    Route::post('register','AuthController@authenticate');
    Route::get('logout','AuthController@logout');
    Route::get('check','AuthController@check');
});
Route::group(['middleware' => 'auth:api'], function () {
    
    Route::post('update_user','UserController@updateUser');
    Route::post('book_lottery_numbers','UserLotteryNumberController@bookLotteryNumbers');
    Route::get('my_lottery_numbers','UserLotteryNumberController@myLotteryNumbers');
    Route::get('lottery_info','UserLotteryNumberController@getLotteryInfo');
    
});

// get cms page 
    Route::get('/slugGet/get/{testSlug}',[
        'as' => 'admin.cms', 'uses' => 'CmsPageController@getPageSlug'
    ]);

// session route
Route::post('email-exist',[
    'as' => 'email-exist','uses' => 'Demo\PagesController@emailExist'
]);

// admin route
Route::group(['prefix' => 'admin', 'middleware' => 'api.auth'], function (){

    Route::resource('todos', 'Demo\TodosController');

    Route::post('todos/toggleTodo/{id}', [
        'as' => 'admin.todos.toggle', 'uses' => 'Demo\TodosController@toggleTodo'
    ]);

    Route::group(['prefix' => 'settings'], function () {

        Route::post('/social', [
            'as' => 'admin.settings.social', 'uses' => 'Demo\SettingsController@postSocial'
        ]);
    });

    Route::group(['prefix' => 'users'], function (){

        Route::get('/get',[
            'as' => 'admin.users', 'uses' => 'UserController@allUsers'
        ]);

        Route::delete('/{id}',[
            'as' => 'admin.users.delete', 'uses' => 'UserController@destroy'
        ]);

    });
    Route::group(['prefix' => 'lottery'], function (){

        Route::get('/get',[
            'as' => 'admin.lottery', 'uses' => 'UserLotteryNumberController@allLotteryNumbersThisWeek'
        ]);
        Route::get('/getJackpotWinner',[
            'as' => 'admin.lottery', 'uses' => 'UserLotteryNumberController@getJackpotWinner'
        ]);
        Route::post('/getLotteryWinners',[
            'as' => 'admin.lottery', 'uses' => 'UserLotteryNumberController@getLotteryWinners'
        ]);

        Route::get('/getWinnersList',[
            'as' => 'admin.lottery', 'uses' => 'UserLotteryNumberController@getWinnersList'
        ]);
        Route::delete('/{id}',[
            'as' => 'admin.users.delete', 'uses' => 'UserController@destroy'
        ]);

    });
    // Cms
    Route::group(['prefix' => 'cms'], function (){

        // CMS Crud
        Route::get('/get',[
            'as' => 'admin.cms', 'uses' => 'CmsPageController@allCmsPages'
        ]);
        Route::get('/edit/{id}',[
            'as' => 'admin.cities.edit', 'uses' => 'CmsPageController@editCmsPageByPageID'
        ]);
        
        Route::delete('/{id}',[
            'as' => 'admin.cms.destroy', 'uses' => 'CmsPageController@deleteCmsPageByID'
        ]);

        Route::post('/update', [
            'as' => 'admin.cms.update', 'uses' => 'CmsPageController@updateCmsPage'
        ]);

        Route::post('/add', [
            'as' => 'admin.cms.add', 'uses' => 'CmsPageController@addNewCmsPage'
        ]);

        // Get Page by Slug
        // Route::get('/slugGet/get/{testSlug}',[
        //     'as' => 'admin.cms', 'uses' => 'CmsPageController@getPageSlug'
        // ]);

    });

});

