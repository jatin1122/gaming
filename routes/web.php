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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index');
Route::get('/rules', 'InfoPagesController@rules');
Route::get('/privacy-policy', 'InfoPagesController@privacyPolicy');
Route::get('/terms-and-conditions', 'InfoPagesController@termsAndConditions');
Route::get('/phylo/deposit-funds', 'PhyloDepositFundsController@index')->middleware('auth:api');
Route::get('/phylo/withdraw-funds', 'PhyloWithdrawFundsController@index')->middleware('auth:api');
Route::post('/phylo/payment-success', 'PhyloDepositFundsController@submit');
Route::post('/phylo/payment-failed', 'PhyloDepositFundsController@paymentFailed');
Route::get('/phylo/payment-failed', 'PhyloDepositFundsController@paymentFailed');
Route::get('/payment-success/{id}', 'PhyloDepositFundsController@paymentSuccess');
Route::get('/phylo/payout-failed', 'PhyloWithdrawFundsController@payoutFailed');
Route::get('/phylo/payout-success/{id}', 'PhyloWithdrawFundsController@payoutSuccess');
Auth::routes();

Route::get('/account/banned', 'Auth\BannedController@display')->middleware('banned.only')->name('banned');

Route::get('/account', 'AccountController@index')->name('account');
Route::get('/account/funds', 'AccountController@funds')->name('account-funds');
Route::get('/account/funds/deposit', 'DepositFundsController@index')->name('account-deposit');
Route::post('/account/funds/deposit', 'DepositFundsController@submitPayment')->name('account-deposit-submit');
Route::get('/account/funds/withdraw', 'WithdrawFundsController@index')->name('account-withdraw');
Route::get('/account/funds/delete/{ref}', 'DeleteCardController@index')->name('card-delete');
Route::post('/account/funds/delete/{ref}', 'DeleteCardController@confirm');
Route::get('/account/settings', 'AccountSettingsController@index')->name('account-settings');
Route::get('/account/history', 'AccountHistoryController@index')->name('account-history');
Route::post('/account/settings/update', 'AccountSettingsController@update')->name('update-account-settings');
Route::post('/contact-us', 'HomeController@contact')->name('contact');

// Route::middleware('banned')->group(function () {
//     Route::get('/account/funds/deposit', 'CyberSourceDepositFundsController@index');
//     Route::post('/account/funds/deposit', 'CyberSourceDepositFundsController@submit');
// });

Route::middleware('banned.full')->group(function () {
    Route::get('/account/funds/withdraw', 'CyberSourceWithdrawFundsController@index');
    Route::post('/account/funds/withdraw', 'CyberSourceWithdrawFundsController@submit');
});
