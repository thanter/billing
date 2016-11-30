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


use App\PlanConfig;
use App\User;

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', function(){
    $config = plan();

    dd($config->getPlan('bronze_yearly'));
});


Route::get('/plans', function() {
    // possible uses cases for plan()
    // dd(get_class(plan()));
    // dd(plan()->getPlan('planName'))

    // plan('silver') or plan('bronze')
    dd(plan('free_'));

    // plan('silver_yearly' or plan('golden_monthly')
    // dd(plan('golden_monthly'));
    // dd(plan('golden_monthly', 'limits.entries'));
    // dd(plan('silver_monthly', 'entries'));


    // plan('limits.entries') or plan('entries')
    // dd(plan('limits.entries'));
    // dd(plan('entries'));
});


Route::group(['middleware' => 'auth'], function () {

    /***** Current subscription status *****/
    Route::get('subscription', 'BillingController@subscription')->name('subscription.status');


    /***** Getting a new subscription *****/
    // GET
    Route::get('subscribe/{plan}', 'BillingController@subscribe')
//        ->where('plan', "high_monthly|low_monthly")
        ->name('subscribe');
    // POST
    Route::post('subscribe/{plan}', 'BillingController@postSubscribe')
//        ->where('plan', "high_monthly|low_monthly")
        ->middleware('reset')
        ->name('subscribe');


    /***** Cancel subscription *****/
    Route::get('subscription/cancel', 'BillingController@cancelSubscription')->name('subscription.cancel');
    Route::get('subscription/cancelNow', 'BillingController@cancelSubscriptionForGood')->name('subscription.cancelNow');
    Route::get('subscription/reactivate', 'BillingController@reactivateSubscription')->name('subscription.reactivate');


    /***** Change subscription *****/
    Route::get('subscription/upgrade', 'BillingController@upgrade')->name('subscription.upgrade');
    Route::get('subscription/downgrade', 'BillingController@downgrade')->name('subscription.downgrade');


    /***** Invoices *****/
    Route::get('invoice', 'InvoicesController@all')->name('invoices');
    Route::get('invoice/download/{id}', 'InvoicesController@download')->name('invoice.download');


    /***** Payment methods *****/
    Route::get('paying', 'PayingMethodsController@defaultMethod')->name('payment.method');
    Route::post('paying', 'PayingMethodsController@update')->name('payment.method');
});

/***** Webhooks *****/
Route::post('braintree/webhook', 'WebhookController@handleWebhook');