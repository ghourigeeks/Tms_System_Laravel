<?php

	use Illuminate\Support\Facades\Route;
	use App\Http\Controllers\UserController;
	use App\Http\Controllers\RoleController;
	use App\Http\Controllers\CityController;
	use App\Http\Controllers\StatusController;
	use App\Http\Controllers\ReasonController;
	use App\Http\Controllers\PeopleController;
	use App\Http\Controllers\RatingController;
	use App\Http\Controllers\CaptainController;
	use App\Http\Controllers\ProvinceController;
	use App\Http\Controllers\ComplaintController;
	use App\Http\Controllers\PassengerController;
	use App\Http\Controllers\TwilioSMSController;
	use App\Http\Controllers\PermissionController;
	use App\Http\Controllers\Complaint_tagController;
	use App\Http\Controllers\Payment_methodController;

	Auth::routes();

	Route::get('/', function () {
		if(Auth::check()) {
			return redirect('/home');
		} else {
			return view('auth.login');
		}
	});

	// Route::get('send_otp/{contact_no}/{code}', [TwilioSMSController::class, 'index']);

	Route::get('/send_sms/{contact_no}',[App\Http\Controllers\NotificationController::class, 'send_sms']);

	Route::group(['middleware' => ['auth']], function() {
		Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


		Route::resource('/peoples',PeopleController::class);
		Route::get('/lst_people', [PeopleController::class, 'list']);
		Route::delete('/del_people', [PeopleController::class, 'destroy']);

		Route::group(['prefix' => 'peoples'], function () {
			Route::get('/shdls/{id}', [PeopleController::class, 'schedules']);
			Route::get('/shdls_lst/{id}', [PeopleController::class, 'schedules_lst']);
			Route::get('/shdls/shdl/{id}', [PeopleController::class, 'schedule_show']);

			Route::get('/cmplnts/{id}', [PeopleController::class, 'complaints']);
			Route::get('/cmplnts_lst/{id}', [PeopleController::class, 'complaints_lst']);

			Route::get('/rtngs/{id}', [PeopleController::class, 'ratings']);
			Route::get('/rtngs_lst/{id}', [PeopleController::class, 'ratings_lst']);

			Route::get('/bkngs/{id}', [PeopleController::class, 'bookings']);
			Route::get('/bkngs_lst/{id}', [PeopleController::class, 'bookings_lst']);
		});

	
	// BEGIN::Rating
		Route::resource('/ratings', RatingController::class);
		Route::get('/lst_rating', [RatingController::class, 'list']);
		Route::delete('/del_rating', [RatingController::class, 'destroy']);
	// BEGIN::Rating


	// BEGIN::Province
		Route::resource('/provinces', ProvinceController::class);
		Route::get('/lst_province', [ProvinceController::class, 'list']);
		Route::delete('/del_province', [ProvinceController::class, 'destroy']);
	// BEGIN::Province


	// BEGIN::city
		Route::resource('/cities', CityController::class);
		Route::get('/lst_city', [CityController::class, 'list']);
		Route::delete('/del_city', [CityController::class, 'destroy']);
	// END::city

	// BEGIN::reasons
		Route::resource('/reasons', ReasonController::class);
		Route::get('/lst_reason', [ReasonController::class, 'list']);
		Route::delete('/del_reason', [ReasonController::class, 'destroy']);
	// END::reasons

	// BEGIN::statuses
		Route::resource('/statuses', StatusController::class);
		Route::get('/lst_status', [StatusController::class, 'list']);
		Route::delete('/del_status', [StatusController::class, 'destroy']);
	// BEGIN::statuses

	// BEGIN::payment_methods
		Route::resource('/payment_methods', Payment_methodController::class);
		Route::get('/lst_payment_method', [Payment_methodController::class, 'list']);
		Route::delete('/del_payment_method', [Payment_methodController::class, 'destroy']);
	// BEGIN::payment_methods

	
	// BEGIN::complaint_tags
		Route::resource('/complaint_tags', Complaint_tagController::class);
		Route::get('/lst_complaint_tags', [Complaint_tagController::class, 'list']);
		Route::delete('/del_complaint_tag', [Complaint_tagController::class, 'destroy']);
	// BEGIN::complaint_tags

	// BEGIN::users
		Route::resource('/users', UserController::class);
		Route::get('/lst_user', [UserController::class, 'list']);
		Route::delete('/del_user', [UserController::class, 'destroy']);
	// BEGIN::users

	// BEGIN::roles
		Route::resource('/roles', RoleController::class);
		Route::get('/lst_role', [RoleController::class, 'list']);
		Route::delete('/del_role', [RoleController::class, 'destroy']);
	// BEGIN::roles

	// BEGIN::permissions
		// Route::resource('/permissions', PermissionController::class);
		// Route::get('/lst_permission', [PermissionController::class, 'list']);
		// Route::delete('/del_permission', [PermissionController::class, 'destroy']);
	// BEGIN::permissions



});


