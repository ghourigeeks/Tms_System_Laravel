<?php

	use Illuminate\Support\Facades\Route;
	use App\Http\Controllers\UserController;
	use App\Http\Controllers\RoleController;
	use App\Http\Controllers\TwilioSMSController;
	use App\Http\Controllers\PermissionController;
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
	use App\Http\Controllers\FaqController;
	use App\Http\Controllers\NotificationController;

	
	Auth::routes();

	Route::get('/', function () {
		if(Auth::check()) {
			return redirect('/home');
		} else {
			return view('auth.login');
		}
	});

	// Route::get('send_otp/{contact_no}/{code}', [TwilioSMSController::class, 'index']);

	Route::get('/send_sms/{contact_no}',[NotificationController::class, 'send_sms']);

	Route::group(['middleware' => ['auth']], function() {
		Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

		Route::resource('/clients',ClientController::class);
		Route::get('/lst_client', [ClientController::class, 'list']);
		Route::delete('/del_client', [ClientController::class, 'destroy']);

		Route::group(['prefix' => 'clients'], function () {
			Route::get('/boxes/{id}', [ClientController::class, 'boxes']);
			Route::get('/fetchBoxes/{id}', [ClientController::class, 'fetchBoxes']);
			Route::get('/boxes/box/{id}', [ClientController::class, 'showBox']);


			Route::get('/products/{id}', [ClientController::class, 'products']);
			Route::get('/fetchProducts/{id}', [ClientController::class, 'fetchProducts']);
			Route::get('/products/product/{id}', [ClientController::class, 'showProduct']);


			Route::get('/ibeacons/{id}', [ClientController::class, 'ibeacons']);
			Route::get('/fetchIbeacons/{id}', [ClientController::class, 'fetchIbeacons']);
			Route::get('/ibeacons/ibeacon/{id}', [ClientController::class, 'showIbeacon']);


			Route::get('/complaints/{id}', [ClientController::class, 'complaints']);
			Route::get('/fetchComplaints/{id}', [ClientController::class, 'fetchComplaints']);
			Route::get('/complaints/complaint/{id}', [ClientController::class, 'showComplaint']);

		});


	// BEGIN::categories
		Route::resource('/categories', CategoryController::class);
		Route::get('/lst_category', [CategoryController::class, 'list']);
		Route::delete('/del_category', [CategoryController::class, 'destroy']);
	// BEGIN::categories

	// BEGIN::complaints
		Route::resource('/complaints', ComplaintController::class);
		Route::get('/lst_complaint', [ComplaintController::class, 'list']);
		// Route::delete('/del_complaint_tag', [Complaint_tagController::class, 'destroy']);
	// BEGIN::complaints

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

	// BEGIN::product
		Route::resource('/products', ProductController::class);
		Route::get('/lst_product', [ProductController::class, 'list']);
		Route::delete('/del_product', [ProductController::class, 'destroy']);
	// BEGIN::product

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

    // BEGIN::faq
		Route::resource('/faqs', FaqController::class);
		Route::get('/lst_faq', [FaqController::class, 'list']);
		Route::delete('/del_faq', [FaqController::class, 'destroy']);
	// END::faq

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


