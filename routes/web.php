<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\DoctorLoginController;
use App\Http\Controllers\frontend\RegistrationsController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('SwitchLang/{lang}',function($lang){
    session()->put('Lang',$lang);
    app()->setLocale($lang);
    if (auth()->check()) {
        $user = App\Models\User::find(auth()->user()->id)->update(['language'=>$lang]);
    }
	return Redirect::back();
});

Auth::routes();
Route::get('admin/auth/login',[AdminLoginController::class,'@login'])->name('admin.login');
Route::get('doctor/auth/login','DoctorLoginController@login')->name('doctor.login');
Route::get('publisher/auth/login','publishers\PublisherLoginController@login')->name('publisher.login');

Route::get('convert-payments-to-revenues','system\customOldDataController@ConvertPaymentsToRevenues')->name('system.convertPaymentsToRevenues');
Route::get('convert-funds-to-revenues-expenses','system\customOldDataController@ConvertTransfersToRevenuesExpenses')->name('system.ConvertTransfersToRevenuesExpenses');
Route::get('refineExpensesDays','system\customOldDataController@refineExpensesDays')->name('system.refineExpensesDays');
Route::get('refineRevenuesDays','system\customOldDataController@refineRevenuesDays')->name('system.refineRevenuesDays');


Route::get('/client-register',[RegistrationsController::class,'index']);
Route::post('/store', [RegistrationsController::class,'store'])->name('frontend.reservations.store');

