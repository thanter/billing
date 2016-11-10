<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use App\User;

Route::get('/', function () {
    return view('welcome');
});


Route::get("/nteath", function()
{
    $user = User::find(2);

    $subscription = $user->subscription();

    $plan = $subscription->plan;

    dd($plan);

    return $user->subscription();
});



Auth::routes();

Route::get('/home', 'HomeController@index');



Route::get('subscribe/{plan}', 'BillingController@getSubscribe')
    ->where('plan', "high|low")
    ->name('subscribe');
Route::post('subscribe/{plan}', 'BillingController@postSubscribe')
    ->where('plan', "high_monthly|low_monthly")
    ->name('subscribe');


Route::get('subscription', 'BillingController@getSubscription');
Route::get('subscription/cancel', 'BillingController@cancelSubscription');

Route::get('paying', 'BillingController@getPayingMethod');
Route::post('paying', 'BillingController@postPayingMethod');