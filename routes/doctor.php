<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\doctor\DoctorPanelController;
use App\Http\Controllers\doctor\AppointmentsController;
use App\Http\Controllers\doctor\ClientsController;


Route::group(['prefix'=>'DoctorPanel','middleware'=>['isAdmin','auth']], function(){

    Route::get('/',[DoctorPanelController::class, 'index'])->name('doctor.index');

    Route::get('/read-all-notifications',[DoctorPanelController::class, 'readAllNotifications'])->name('doctor.notifications.readAll');
    Route::get('/notification/{id}/details',[DoctorPanelController::class, 'notificationDetails'])->name('doctor.notification.details');

    Route::get('/my-salary',[DoctorPanelController::class, 'mySalary'])->name('doctor.mySalary');
    Route::get('/my-profile',[DoctorPanelController::class, 'EditProfile'])->name('doctor.myProfile');
    Route::post('/my-profile',[DoctorPanelController::class, 'UpdateProfile'])->name('doctor.myProfile.update');
    Route::get('/my-password',[DoctorPanelController::class, 'EditPassword'])->name('doctor.myPassword');
    Route::post('/my-password',[DoctorPanelController::class, 'UpdatePassword'])->name('doctor.myPassword.update');


    Route::post('/{id}/Edit', [AppointmentsController::class, 'update'])->name('doctor.appointments.update');
    Route::get('/{id}/EditStatus', [AppointmentsController::class, 'updateStatus'])->name('doctor.appointments.updateStatus');

    Route::get('/clients/{id}/details', [ClientsController::class, 'details'])->name('doctor.clients.details');

});
