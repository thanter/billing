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


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/***** Getting a new subscription *****/
// GET
Route::get('subscribe/{plan}', 'BillingController@getSubscribe')
    ->where('plan', "high_monthly|low_monthly")
    ->name('subscribe');
// POST
Route::post('subscribe/{plan}', 'BillingController@postSubscribe')
    ->where('plan', "high_monthly|low_monthly")
    ->name('subscribe');


Route::get('subscription', 'BillingController@getSubscription')->name('subscription.status');


Route::get('subscription/cancel', 'BillingController@cancelSubscription')->name('subscription.cancel');
Route::get('subscription/cancelNow', 'BillingController@cancelSubscriptionForGood')->name('subscription.cancelNow');
Route::get('subscription/reactivate', 'BillingController@reactivateSubscription')->name('subscription.reactivate');

Route::get('subscription/upgrade', 'BillingController@upgrade')->name('subscription.upgrade');
Route::get('subscription/downgrade', 'BillingController@downgrade')->name('subscription.downgrade');

Route::get('paying', 'BillingController@getPayingMethod')->name('payment.method');
Route::post('paying', 'BillingController@postPayingMethod')->name('payment.method');


Route::get('invoice', 'BillingController@invoices')->name('invoices');


//Route::get(
//    'braintree/webhook',
//    function() {
//        Log::info('check');
//        return response('ok', 201);
//    }
//);
//
//
////Route::post(
////    'braintree/webhook',
////    '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'
////);






Route::get("/nteath", function()
{
    Log::info('here');
    return 'test';
    $user = User::find(2);

    $subscription = $user->subscription();

    return $subscription;

    $plan = $subscription->plan;

    dd($plan);

    return $user->subscription();
});
