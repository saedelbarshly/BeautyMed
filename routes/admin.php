<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\RolesController;
use App\Http\Controllers\admin\CitiesController;
use App\Http\Controllers\admin\hr\JobsController;
use App\Http\Controllers\admin\ReportsController;
use App\Http\Controllers\admin\BranchesController;
use App\Http\Controllers\admin\SettingsController;
use App\Http\Controllers\admin\AdminPanelController;
use App\Http\Controllers\admin\AdminUsersController;
use App\Http\Controllers\admin\hr\SalariesController;
use App\Http\Controllers\admin\AdminDoctorsController;
use App\Http\Controllers\admin\GovernoratesController;
use App\Http\Controllers\admin\hr\AttendanceController;
use App\Http\Controllers\admin\hr\DeductionsController;
use App\Http\Controllers\admin\accounts\SafesController;
use App\Http\Controllers\admin\hr\ManagementsController;
use App\Http\Controllers\admin\services\AreasController;
use App\Http\Controllers\admin\services\OffersController;
use App\Http\Controllers\admin\accounts\ExpensesController;
use App\Http\Controllers\admin\accounts\RevenuesController;
use App\Http\Controllers\admin\services\MachinesController;
use App\Http\Controllers\admin\Reservations\PaymentsController;
use App\Http\Controllers\admin\accounts\ExpensesTypesController;
use App\Http\Controllers\admin\ClientsFollowUps\ClientsController;
use App\Http\Controllers\admin\Reservations\AppointmentsController;
use App\Http\Controllers\admin\Reservations\ReservationsController;
use App\Http\Controllers\admin\ClientsFollowUps\ComplaintsController;
use App\Http\Controllers\admin\services\ManagementServicesController;
use App\Http\Controllers\admin\ClientsFollowUps\ClientProfileController;
use App\Http\Controllers\admin\ClientsFollowUps\RefferalClientsController;


Route::group(['prefix'=>'AdminPanel','middleware'=>['isAdmin','auth']], function(){
    Route::get('/',[AdminPanelController::class, 'index'])->name('admin.index');

    Route::get('/read-all-notifications',[AdminPanelController::class, 'readAllNotifications'])->name('admin.notifications.readAll');
    Route::get('/notification/{id}/details',[AdminPanelController::class, 'notificationDetails'])->name('admin.notification.details');

    Route::get('/my-salary',[AdminPanelController::class, 'mySalary'])->name('admin.mySalary');
    Route::get('/my-profile',[AdminPanelController::class, 'EditProfile'])->name('admin.myProfile');
    Route::post('/my-profile',[AdminPanelController::class, 'UpdateProfile'])->name('admin.myProfile.update');
    Route::get('/my-password',[AdminPanelController::class, 'EditPassword'])->name('admin.myPassword');
    Route::post('/my-password',[AdminPanelController::class, 'UpdatePassword'])->name('admin.myPassword.update');
    Route::get('/notifications-settings',[AdminPanelController::class, 'EditNotificationsSettings'])->name('admin.notificationsSettings');
    Route::post('/notifications-settings',[AdminPanelController::class, 'UpdateNotificationsSettings'])->name('admin.notificationsSettings.update');


    // Users
    Route::get('/employees',[AdminUsersController::class, 'employeesIndex'])->name('admin.employees');
    Route::group(['prefix'=>'users'], function(){
        Route::get('/',[AdminUsersController::class, 'index'])->name('admin.adminUsers');
        Route::get('/create',[AdminUsersController::class, 'create'])->name('admin.adminUsers.create');
        Route::post('/create',[AdminUsersController::class, 'store'])->name('admin.adminUsers.store');
        Route::get('/{id}/block/{action}',[AdminUsersController::class, 'blockAction'])->name('admin.adminUsers.block');
        Route::get('/{id}/edit',[AdminUsersController::class, 'edit'])->name('admin.adminUsers.edit');
        Route::post('/{id}/edit',[AdminUsersController::class, 'update'])->name('admin.adminUsers.update');
        Route::get('/{id}/hrProfile',[AdminUsersController::class, 'hrProfile'])->name('admin.adminUsers.hrProfile');
        Route::post('/{id}/hrProfile',[AdminUsersController::class, 'updateHRProfile'])->name('admin.adminUsers.updateHRProfile');
        Route::get('/{id}/delete',[AdminUsersController::class, 'delete'])->name('admin.adminUsers.delete');
        Route::get('/{id}/DeletePhoto/{photo}/{X}', [AdminUsersController::class, 'DeleteuserPhoto'])->name('admin.users.deletePhoto');
    });


    // Doctors
    Route::group(['prefix'=>'doctors'], function(){
        Route::get('/',[AdminDoctorsController::class, 'index'])->name('admin.doctors');
        Route::get('/create',[AdminDoctorsController::class, 'create'])->name('admin.doctors.create');
        Route::post('/create',[AdminDoctorsController::class, 'store'])->name('admin.doctors.store');
        Route::get('/{id}/block/{action}',[AdminDoctorsController::class, 'blockAction'])->name('admin.doctors.block');
        Route::get('/{id}/edit',[AdminDoctorsController::class, 'edit'])->name('admin.doctors.edit');
        Route::post('/{id}/edit',[AdminDoctorsController::class, 'update'])->name('admin.doctors.update');
        Route::post('/{userId}/{serviceId}/edit',[AdminDoctorsController::class, 'updateCommission'])->name('admin.commission.update');
        Route::get('/{id}/hrProfile',[AdminDoctorsController::class, 'hrProfile'])->name('admin.doctors.hrProfile');
        Route::post('/{id}/hrProfile',[AdminDoctorsController::class, 'updateHRProfile'])->name('admin.doctors.updateHRProfile');
        Route::get('/{id}/delete',[AdminDoctorsController::class, 'delete'])->name('admin.doctors.delete');
        Route::get('/{id}/DeletePhoto/{photo}/{X}', [AdminDoctorsController::class, 'DeleteuserPhoto'])->name('admin.users.deletePhoto');
    });


    // HR >> units
    Route::group(['prefix'=>'managements'], function(){
        Route::get('/',[ManagementsController::class, 'index'])->name('admin.managements');
        Route::post('/create',[ManagementsController::class, 'store'])->name('admin.managements.store');
        Route::post('/{id}/edit',[ManagementsController::class, 'update'])->name('admin.managements.update');
        Route::get('/{id}/delete',[ManagementsController::class, 'delete'])->name('admin.managements.delete');
    });

    // HR >> jobs
    Route::group(['prefix'=>'jobs'], function(){
        Route::get('/',[JobsController::class, 'index'])->name('admin.jobs');
        Route::post('/create',[JobsController::class, 'store'])->name('admin.jobs.store');
        Route::post('/{id}/edit',[JobsController::class, 'update'])->name('admin.jobs.update');
        Route::get('/{id}/delete',[JobsController::class, 'delete'])->name('admin.jobs.delete');
    });

    // HR >> Salaries of Employees
    Route::group(['prefix'=>'SalariesControl'], function(){
        //HR Dep. -> Salaries Managment
        Route::get('/', [SalariesController::class, 'index'])->name('admin.salaries');
        Route::get('/{id}/Salaries', [SalariesController::class, 'EmployeeSalary'])->name('admin.EmployeeSalary');
        Route::post('/{id}/payOutSalary', [SalariesController::class, 'payOutSalary'])->name('admin.payOutSalary');

        Route::post('/{id}/AddPermission', [AttendanceController::class, 'AddPermission'])->name('admin.AddPermission');
        Route::get('/{id}/DeletePermission', [AttendanceController::class, 'DeletePermission'])->name('admin.DeletePermission');
        Route::post('/{id}/AddVacation', [AttendanceController::class, 'AddVacation'])->name('admin.AddVacation');
        Route::get('/Vacations/{id}/delete', [AttendanceController::class, 'DeleteVacation'])->name('admin.DeleteVacation');

        Route::get('/AttendanceList', [AttendanceController::class, 'index'])->name('admin.attendance');
        Route::post('/NewAttendance', [AttendanceController::class, 'SubmitNewAttendance'])->name('admin.attendace.excel');

        Route::get('/AttendanceList/{id}/attend/{date}', [AttendanceController::class, 'employeeAttend'])->name('admin.attendance.employee.attend');
        Route::get('/AttendanceList/{id}/go/{date}', [AttendanceController::class, 'employeeGo'])->name('admin.attendance.employee.go');

        //HR Dep. -> Salaries Managment -> Records
        Route::group(['prefix'=>'{UID}/Attendance'], function(){
            Route::get('/{Date}/EditVacation', [AttendanceController::class, 'EmployeeEditVacation'])->name('EmployeeEditVacation');
            Route::post('/{Date}/EditVacation', [AttendanceController::class, 'EmployeePostEditVacation'])->name('EmployeePostEditVacation');
        });

        //HR Dep. -> Salaries Managment -> Add Deduction
        Route::group(['prefix'=>'deductions'], function(){
            Route::post('/store', [DeductionsController::class, 'store'])->name('admin.deductions.store');
            Route::post('/{id}/Edit', [DeductionsController::class, 'update'])->name('admin.deductions.update');
            Route::get('/{id}/Delete', [DeductionsController::class, 'delete'])->name('admin.deductions.delete');
        });

        //test
        Route::post('/{EID}/PaySalary/{Type}', 'HRDepController@PaySalary')->name('SalaryPay');
        Route::get('/{EID}/PaySalary/{Type}', 'HRDepController@PaySalaryRequest')->name('SalaryPayRequest');
    });


    // Roles
    Route::group(['prefix'=>'roles'], function(){
        Route::post('/CreatePermission',[RolesController::class, 'CreatePermission'])->name('admin.CreatePermission');
        Route::get('/',[RolesController::class, 'index'])->name('admin.roles');
        Route::post('/create',[RolesController::class, 'store'])->name('admin.roles.store');
        Route::post('/{id}/edit',[RolesController::class, 'update'])->name('admin.roles.update');
        Route::get('/{id}/delete',[RolesController::class, 'delete'])->name('admin.roles.delete');
    });


    Route::group(['prefix'=>'governorates'], function(){
        Route::get('/',[GovernoratesController::class, 'index'])->name('admin.governorates');
        Route::post('/create',[GovernoratesController::class, 'store'])->name('admin.governorates.store');
        Route::post('/{governorateId}/edit',[GovernoratesController::class, 'update'])->name('admin.governorates.update');
        Route::get('/{governorateId}/delete',[GovernoratesController::class, 'delete'])->name('admin.governorates.delete');

        Route::group(['prefix'=>'{governorateId}/cities'], function(){
            Route::get('/',[CitiesController::class, 'index'])->name('admin.cities');
            Route::post('/create',[CitiesController::class, 'store'])->name('admin.cities.store');
            Route::post('/{cityId}/edit',[CitiesController::class, 'update'])->name('admin.cities.update');
            Route::get('/{cityId}/delete',[CitiesController::class, 'delete'])->name('admin.cities.delete');
        });
    });

    Route::group(['prefix'=>'settings'], function(){
        Route::get('/',[SettingsController::class, 'generalSettings'])->name('admin.settings.general');
        Route::post('/',[SettingsController::class, 'updateSettings'])->name('admin.settings.update');
        Route::get('/{key}/deletePhoto',[SettingsController::class, 'deleteSettingPhoto'])->name('admin.settings.deletePhoto');
    });

    Route::group(['prefix'=>'branches'], function(){
		Route::get('/', [BranchesController::class, 'index'])->name('admin.branches.index');
		Route::post('/', [BranchesController::class, 'store'])->name('admin.branches.store');
		Route::post('{id}/Edit', [BranchesController::class, 'update'])->name('admin.branches.update');
		Route::get('{id}/Delete', [BranchesController::class, 'delete'])->name('admin.branches.delete');
    });

    Route::group(['prefix'=>'services'], function(){

        Route::group(['prefix'=>'machines'], function(){
            Route::get('/',[MachinesController::class, 'index'])->name('admin.machines');
            Route::post('/create',[MachinesController::class, 'store'])->name('admin.machines.store');
            Route::post('/{machineId}/edit',[MachinesController::class, 'update'])->name('admin.machines.update');
            Route::get('/{machineId}/delete',[MachinesController::class, 'delete'])->name('admin.machines.delete');
        });

        Route::group(['prefix'=>'areas'], function(){
            Route::get('/',[AreasController::class, 'index'])->name('admin.areas');
            Route::post('/create',[AreasController::class, 'store'])->name('admin.areas.store');
            Route::post('/{areaId}/edit',[AreasController::class, 'update'])->name('admin.areas.update');
            Route::get('/{areaId}/delete',[AreasController::class, 'delete'])->name('admin.areas.delete');
        });

        Route::group(['prefix'=>'management-services'], function(){
            Route::get('/',[ManagementServicesController::class, 'index'])->name('admin.services');
            Route::post('/create',[ManagementServicesController::class, 'store'])->name('admin.services.store');
            Route::post('/{serviceId}/edit',[ManagementServicesController::class, 'update'])->name('admin.services.update');
            Route::get('/{serviceId}/delete',[ManagementServicesController::class, 'delete'])->name('admin.services.delete');
            Route::get('/{id}/reports',[ManagementServicesController::class, 'reports'])->name('admin.services.reports');

        });

        Route::group(['prefix'=>'offers'], function(){
            Route::get('/',[OffersController::class, 'index'])->name('admin.offers');
            Route::post('/create',[OffersController::class, 'store'])->name('admin.offers.store');
            Route::post('/{offerId}/edit',[OffersController::class, 'update'])->name('admin.offers.update');
            Route::get('/{offerId}/delete',[OffersController::class, 'delete'])->name('admin.offers.delete');
        });

    });


    /**
	 * Safes Control
	*/
    Route::group(['prefix'=>'Safes'], function(){
		//Safes Control
		Route::get('/', [SafesController::class, 'index'])->name('admin.safes');
		Route::post('/', [SafesController::class, 'store'])->name('admin.safes.store');
		Route::post('/{id}/Edit', [SafesController::class, 'update'])->name('admin.safes.update');
		Route::get('/{id}/Delete', [SafesController::class, 'delete'])->name('admin.safes.delete');
		Route::get('/{id}/Stats', [SafesController::class, 'Stats'])->name('admin.safes.Stats');
    });

    Route::group(['prefix'=>'ExpensesTypes'], function(){
        Route::get('/', [ExpensesTypesController::class, 'index'])->name('admin.expensesTypes');
        Route::post('/create', [ExpensesTypesController::class, 'store'])->name('admin.expensesTypes.store');
        Route::post('/{id}/Edit', [ExpensesTypesController::class, 'update'])->name('admin.expensesTypes.update');
        Route::get('/{id}/Delete', [ExpensesTypesController::class, 'delete'])->name('admin.expensesTypes.delete');
    });

    Route::group(['prefix'=>'expenses'], function(){
        Route::get('/', [ExpensesController::class, 'index'])->name('admin.expenses');
        Route::post('/NewExpense', [ExpensesController::class, 'store'])->name('admin.expenses.store');
        Route::post('/{id}/Edit', [ExpensesController::class, 'update'])->name('admin.expenses.update');
        Route::get('/{id}/DeletePhoto/{photo}/{X}', [ExpensesController::class, 'deletePhoto'])->name('admin.expenses.deletePhoto');
        Route::get('/{id}/Delete', [ExpensesController::class, 'delete'])->name('admin.expenses.delete');
    });

    Route::group(['prefix'=>'revenues'], function(){
        Route::get('/', [RevenuesController::class, 'index'])->name('admin.revenues');
        Route::post('/NewExpense', [RevenuesController::class, 'store'])->name('admin.revenues.store');
        Route::post('/{id}/Edit', [RevenuesController::class, 'update'])->name('admin.revenues.update');
        Route::get('/{id}/DeletePhoto/{photo}/{X}', [RevenuesController::class, 'deletePhoto'])->name('admin.revenues.deletePhoto');
        Route::get('/{id}/Delete', [RevenuesController::class, 'delete'])->name('admin.revenues.delete');
    });



    /**
	*
	* ClientsControl
	*/
	Route::group(['prefix'=>'clients'], function(){
		Route::get('/', [ClientsController::class, 'index'])->name('admin.clients');
        Route::post('/{id}/addComplaint', [ClientsController::class, 'addComplaint'])->name('admin.clients.addComplaint');
        Route::post('/{id}/cashBack', [ClientsController::class, 'cashBack'])->name('admin.clients.cashBack');
		Route::post('/store', [ClientsController::class, 'store'])->name('admin.clients.store');
		Route::post('/createExcelClient', [ClientsController::class, 'storeExcelClient'])->name('admin.clients.storeExcelClient');
		Route::post('/{id}/Edit', [ClientsController::class, 'update'])->name('admin.clients.update');
        Route::get('/{id}/block/{action}',[ClientsController::class, 'blockAction'])->name('admin.clients.block');
		Route::get('/{id}/Delete', [ClientsController::class, 'delete'])->name('admin.clients.delete');
		Route::get('/noAgentClients', [ClientsController::class, 'noAgentClients'])->name('admin.noAgentClients');
		Route::post('/NoAgent/changeAgent', [ClientsController::class, 'changeAgent'])->name('admin.noAgentClients.asignAgent');

        Route::group(['prefix'=>'reservations'], function(){
            Route::get('/', [ReservationsController::class, 'index'])->name('admin.reservations');
            Route::post('/store', [ReservationsController::class, 'store'])->name('admin.reservations.store');  
            Route::get('/filter',[ReservationsController::class, 'filterReservations'])->name('admin.filterReservations');
            Route::post('/{id}/Edit', [ReservationsController::class, 'update'])->name('admin.reservations.update');
            Route::get('/{id}/EditStatus', [ReservationsController::class, 'updateStatus'])->name('admin.reservations.updateStatus');
            Route::get('/{id}/Delete', [ReservationsController::class, 'delete'])->name('admin.reservations.delete');

            Route::post('/movePulses', [ReservationsController::class, 'movePulses'])->name('admin.reservations.movePulses.store');
            Route::post('/movePayment', [ReservationsController::class, 'movePayment'])->name('admin.reservations.movePayment.store');

        });

        Route::group(['prefix'=>'appointments'], function(){
            Route::get('/{id}', [AppointmentsController::class, 'index'])->name('admin.appointments');
            Route::post('/{id}/store', [AppointmentsController::class, 'store'])->name('admin.appointments.store');
            Route::post('/{id}/{id1}/Edit', [AppointmentsController::class, 'update'])->name('admin.appointments.update');
            Route::get('/{id}/EditStatus', [AppointmentsController::class, 'updateStatus'])->name('admin.appointments.updateStatus');
            Route::get('/{id}/Delete', [AppointmentsController::class, 'delete'])->name('admin.appointments.delete');
            Route::post('/getAvailableTimes', [AppointmentsController::class, 'getAvailableTimes'])->name('admin.getAvailableTimes');
        });


        Route::group(['prefix'=>'payments'], function(){
            Route::get('/{id}', [PaymentsController::class, 'index'])->name('admin.payments');
            Route::post('/store', [PaymentsController::class, 'store'])->name('admin.payments.store');
            Route::post('/{id}/Edit', [PaymentsController::class, 'update'])->name('admin.payments.update');
            Route::get('/{id}/Delete', [PaymentsController::class, 'delete'])->name('admin.payments.delete');
        });


        Route::group(['prefix'=>'complaints'], function(){
            Route::get('/', [ComplaintsController::class, 'index'])->name('admin.complaints');
            Route::post('/store', [ComplaintsController::class, 'store'])->name('admin.complaints.store');
            Route::post('/{id}/Edit', [ComplaintsController::class, 'update'])->name('admin.complaints.update');
            Route::get('/{id}/Delete', [ComplaintsController::class, 'delete'])->name('admin.complaints.delete');
        });

        Route::get('/{id}/profile', [ClientProfileController::class, 'showProfile'])->name('admin.clients.profile');


        Route::group(['prefix'=>'refferalClients'], function(){
            Route::get('/', [RefferalClientsController::class, 'index'])->name('admin.refferalClients');
            Route::post('/store', [RefferalClientsController::class, 'store'])->name('admin.refferalClients.store');
            Route::post('/{id}/Edit', [RefferalClientsController::class, 'update'])->name('admin.refferalClients.update');
            Route::get('/{id}/Delete', [RefferalClientsController::class, 'delete'])->name('admin.refferalClients.delete');
        });




    });

	Route::group(['prefix'=>'reports'], function(){
		Route::get('/userFollowUpsReport', [ReportsController::class, 'userFollowUpsReport'])->name('admin.userFollowUpsReport');
		Route::get('/teamFollowUpsReport', [ReportsController::class, 'teamFollowUpsReport'])->name('admin.teamFollowUpsReport');
		Route::get('/branchFollowUpsReport', [ReportsController::class, 'branchFollowUpsReport'])->name('admin.branchFollowUpsReport');
		Route::get('/accountsReport', [ReportsController::class, 'accountsReport'])->name('admin.accountsReport');
	});

});
