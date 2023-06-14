<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CaptainController;
use App\Http\Controllers\API\MainController;
use App\Http\Controllers\API\PassengerController;
use App\Http\Controllers\API\MessageController;

use App\Events\Message;




    Route::post('/get_recent_people', [MessageController::class, 'get_recent_people']);
    Route::post('/send_message', [MessageController::class, 'send_message']);
    Route::post('/fetch_messages', [MessageController::class, 'fetch_messages']);
    Route::get("get_captain_details/{captain_id}",[MessageController::class, 'get_captain_details']);



    Route::post("login",[MainController::class, 'login']);  //done
    Route::post("register",[MainController::class, 'register'])->name('register');  //done
    Route::post("verify_otp",[MainController::class, 'verify_otp']);  //done
    Route::post("forgot",[MainController::class, 'forgot']);  //done
    Route::post("forgot_otp",[MainController::class, 'forgot_otp']);  //done




    Route::group(['middleware' => 'auth:sanctum'], function(){

        Route::post("fetch_provinces",[MainController::class, 'fetch_provinces']);  //done
        Route::post("fetch_cities",[MainController::class, 'fetch_cities']);  //done

        Route::post("fetch_schedule_by_people",[MainController::class, 'fetch_schedule_by_people']);  //done
        Route::post("fetch_schedule_by_city",[MainController::class, 'fetch_schedule_by_city']);  //done
        Route::post("fetch_schedule_by_date",[MainController::class, 'fetch_schedule_by_date']);  //done
        Route::post("fetch_schedule_by_time",[MainController::class, 'fetch_schedule_by_time']);  //done

        Route::post("cancel_booking",[MainController::class, 'cancel_booking']);  //done
        Route::post("mark_booking_complete",[MainController::class, 'mark_booking_complete']); //done
        Route::post("cancel_schedule",[MainController::class, 'cancel_schedule']);  //done

        Route::post("store_booking",[MainController::class, 'store_booking']);  //done
        Route::post("fetch_booking",[MainController::class, 'fetch_booking']); // NA
        Route::post("fetch_bookings",[MainController::class, 'fetch_bookings']); //done

        Route::post("fetch_cancel_reasons",[MainController::class, 'fetch_cancel_reasons']);  //done
        Route::post("fetch_ratings",[MainController::class, 'fetch_ratings']);  //done
        Route::post("store_ratings",[MainController::class, 'store_ratings']);  //done

        Route::post("fetch_ride_history",[MainController::class, 'fetch_ride_history']);  //done
        Route::post("store_schedule",[MainController::class, 'store_schedule']);  // NA
        Route::post("fetch_schedules",[MainController::class, 'fetch_schedules']);  //done

        Route::post("store_details",[MainController::class, 'store_details']);    // to become captain   //done
        Route::post("fetch_people_vehicle",[MainController::class, 'fetch_people_vehicle']); //done
        Route::post("store_people_vehicle",[MainController::class, 'store_people_vehicle']); //done
        Route::post("update_people_vehicle",[MainController::class, 'update_people_vehicle']); //done

        // Route::get("chart/{captain_id}",[CaptainController::class, 'charts']);

        Route::post("update_password",[MainController::class, 'update_password']);  //done
        Route::post("toggle_role",[MainController::class, 'toggle_role']);  //done
        Route::post("update_profile",[MainController::class, 'update_profile']);
        Route::post("logout",[MainController::class, 'logout']);
    });
