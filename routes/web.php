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
	use App\Http\Controllers\PassengerController;
	use App\Http\Controllers\TwilioSMSController;
	use App\Http\Controllers\PermissionController;
	use App\Http\Controllers\Complaint_tagController;
	use App\Http\Controllers\Payment_methodController;
	use App\Http\Controllers\PackageController;
	use App\Http\Controllers\CategoryController;
	use App\Http\Controllers\RegionController;
	use App\Http\Controllers\CountryController;
	use App\Http\Controllers\ClientController;
	use App\Http\Controllers\ProductController;
	use App\Http\Controllers\BoxController;
	use App\Http\Controllers\IbeaconController;
	use App\Http\Controllers\ComplaintController;
	
	
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

		Route::resource('/clients',ClientController::class);
		Route::get('/lst_client', [ClientController::class, 'list']);
		Route::delete('/del_client', [ClientController::class, 'destroy']);

		Route::group(['prefix' => 'clients'], function () {
			Route::get('/boxes/{id}', [ClientController::class, 'boxes']);
			Route::get('/boxes_lst/{id}', [ClientController::class, 'boxes_lst']);
			Route::get('/boxes/box/{id}', [ClientController::class, 'showBox']);


			Route::get('/products/{id}', [ClientController::class, 'products']);
			Route::get('/products_lst/{id}', [ClientController::class, 'products_lst']);
			Route::get('/products/product/{id}', [ClientController::class, 'showProduct']);


			Route::get('/ibeacons/{id}', [ClientController::class, 'ibeacons']);
			Route::get('/ibeacons_lst/{id}', [ClientController::class, 'ibeacons_lst']);
			Route::get('/ibeacons/ibeacon/{id}', [ClientController::class, 'showIbeacon']);

		});




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


	// BEGIN::Province
		Route::resource('/categories', CategoryController::class);
		Route::get('/lst_category', [CategoryController::class, 'list']);
		Route::delete('/del_category', [CategoryController::class, 'destroy']);
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


	// Itag URLS

	// BEGIN::complaint_tags
		Route::resource('/complaints', ComplaintController::class);
		// Route::get('/lst_complaint_tags', [Complaint_tagController::class, 'list']);
		// Route::delete('/del_complaint_tag', [Complaint_tagController::class, 'destroy']);
	// BEGIN::complaint_tags



	// BEGIN::Payment
		Route::resource('/payments', Payment_methodController::class);
		Route::get('/lst_payment', [Payment_methodController::class, 'list']);
		Route::delete('/del_payment', [Payment_methodController::class, 'destroy']);
	// BEGIN::Payment

	// BEGIN::package
		Route::resource('/packages', PackageController::class);
		Route::get('/lst_package', [PackageController::class, 'list']);
		Route::delete('/del_package', [PackageController::class, 'destroy']);
	// BEGIN::package

	// BEGIN::region
		Route::resource('/regions', RegionController::class);
		Route::get('/lst_region', [RegionController::class, 'list']);
		Route::delete('/del_region', [RegionController::class, 'destroy']);
	// BEGIN::region

	// BEGIN::country
		Route::resource('/countries', CountryController::class);
		Route::get('/lst_country', [CountryController::class, 'list']);
		Route::delete('/del_country', [CountryController::class, 'destroy']);
	// BEGIN::country

	// BEGIN::categories
		Route::resource('/products', ProductController::class);
		Route::get('/lst_product', [ProductController::class, 'list']);
		Route::delete('/del_product', [ProductController::class, 'destroy']);
	// BEGIN::categories

	// BEGIN::Box
		Route::resource('/boxes', BoxController::class);
		Route::get('/lst_box', [BoxController::class, 'list']);
		Route::delete('/del_box', [BoxController::class, 'destroy']);
	// BEGIN::Box

	// BEGIN::Ibeacon
		Route::resource('/ibeacons', IbeaconController::class);
		Route::get('/lst_ibeacon', [IbeaconController::class, 'list']);
		Route::delete('/del_ibeacon', [IbeaconController::class, 'destroy']);
	// BEGIN::Ibeacon

	// BEGIN::Categories
		Route::resource('/categories', CategoryController::class);
		Route::get('/list_category', [CategoryController::class, 'list_category']);
		Route::delete('/del_category', [CategoryController::class, 'del_category']);
	// END::Categories



});


