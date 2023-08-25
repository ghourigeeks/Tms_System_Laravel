<?php

	use Illuminate\Support\Facades\Route;
	use App\Http\Controllers\UserController;
	use App\Http\Controllers\RoleController;
	use App\Http\Controllers\OrderController;
	use App\Http\Controllers\CategoryController;
	use App\Http\Controllers\ClientController;
	use App\Http\Controllers\FeedbackController;
	use App\Http\Controllers\RevisionController;
	use App\Http\Controllers\ContestController;
	use App\Http\Controllers\LeaveController;
	use App\Http\Controllers\HomeController;


	
	Auth::routes();

	Route::get('/', function () {
		if(Auth::check()) {
			return redirect('/home');
		} else {
			return view('auth.login');
		}
	});

	// Route::get('send_otp/{contact_no}/{code}', [TwilioSMSController::class, 'index']);

	Route::group(['middleware' => ['auth']], function() {
		
		Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


	// BEGIN::order
		Route::resource('/orders', OrderController::class);
		Route::get('/lst_order', [OrderController::class, 'list']);
		Route::delete('/del_order', [OrderController::class, 'destroy']);
		Route::get('orders_export',[OrderController::class, 'get_order_data'])->name('orders.export');
	// BEGIN::order

	// BEGIN::category
		Route::resource('/categories', CategoryController::class);
		Route::get('/lst_category', [CategoryController::class, 'list']);
		Route::delete('/del_category', [CategoryController::class, 'destroy']);
	// BEGIN::category

	// BEGIN::client
		Route::resource('/clients', ClientController::class);
		Route::get('/lst_client', [ClientController::class, 'list']);
		Route::delete('/del_client', [ClientController::class, 'destroy']);
	// BEGIN::client

	// BEGIN::Revision
		Route::resource('/revisions', RevisionController::class);
		Route::get('/lst_revision', [RevisionController::class, 'list']);
		Route::delete('/del_revision', [RevisionController::class, 'destroy']);
		Route::get('revisions_export',[RevisionController::class, 'get_revision_data'])->name('revisions.export');
	// BEGIN::Revision

        // BEGIN::Contest
		Route::resource('/contests', ContestController::class);
		Route::get('/lst_contest', [ContestController::class, 'list']);
		Route::delete('/del_contest', [ContestController::class, 'destroy']);
        // BEGIN::Contest

        // BEGIN::Leave
		Route::resource('/leaves', LeaveController::class);
		Route::get('/lst_leaves', [LeaveController::class, 'list']);
		Route::delete('/del_leave', [LeaveController::class, 'destroy']);
        // BEGIN::Leave


	// BEGIN::users
		Route::resource('/users', UserController::class);
		Route::get('/lst_user', [UserController::class, 'list']);
		Route::delete('/del_user', [UserController::class, 'destroy']);
	// BEGIN::users

        // BEGIN::feedbacks
		Route::resource('/feedbacks', FeedbackController::class);
	// BEGIN::feedbacks

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