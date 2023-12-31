<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MainController;

use App\Events\Message;
    
    Route::post("signIn",[MainController::class, 'signIn']);
    Route::post("signUp",[MainController::class, 'signUp']);
    
    Route::post("forgot",[MainController::class, 'forgot']);
    Route::post("resetPassword",[MainController::class, 'resetPassword']);
    Route::get("fetchPackages",[MainController::class, 'fetchPackages']);
    Route::get("fetchPaymentMethods",[MainController::class, 'fetchPaymentMethods']);
    Route::get("fetchProfile/{client_id}",[MainController::class, 'fetchProfile']);
    Route::post("updateProfile",[MainController::class, 'updateProfile']);
    Route::get("fetchDashboard/{client_id}",[MainController::class, 'fetchDashboard']);
    Route::get("fetchCategory",[MainController::class, 'fetchCategory']);
    Route::get("fetchSubCategory/{cat_id}",[MainController::class, 'fetchSubCategory']);
    
    Route::post("logout",[MainController::class, 'logout']);

  
    /*   
        
    Route::group(['middleware' => 'auth:sanctum'], function(){
      
        Route::post("logout",[MainController::class, 'logout']);
    });

    */

 