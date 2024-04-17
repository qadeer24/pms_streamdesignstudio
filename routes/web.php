<?php

	use Illuminate\Support\Facades\Route;
	use App\Http\Controllers\UserController;
	use App\Http\Controllers\RoleController;
	use App\Http\Controllers\CategoryController;
	use App\Http\Controllers\FrameWorkController;
	use App\Http\Controllers\CommentController;
	use App\Http\Controllers\ProjectController;
	use App\Http\Controllers\TaskController;
	use App\Http\Controllers\TwilioSMSController;
	Auth::routes();

	Route::get('/', function () {
		if(Auth::check()) {
			return redirect('/home');
		} else {
			return view('auth.login');
		}
	});

	Route::get('reset_pass',[UserController::class, 'reset_pass_view'])->name('reset_pass');

	Route::get('register/{email}/{id}/{role}',[UserController::class, 'show_invited_details'])->name('show_invited_details');
	
	Route::get('new_pass',[UserController::class, 'new_pass'])->name('new_pass');

	Route::get('confirm_pin',[UserController::class, 'confirm_pin'])->name('confirm_pin');

	Route::post('reset_pass_details',[UserController::class, 'reset_pass'])->name('reset_pass_details');
	
	Route::post('detail_new_pass',[UserController::class, 'detail_new_pass'])->name('detail_new_pass');

	Route::post('confirm_code',[UserController::class, 'confirm_code'])->name('confirm_code');


	Route::get('/send_sms/{contact_no}',[App\Http\Controllers\NotificationController::class, 'send_sms']);

	Route::group(['middleware' => ['auth']], function() {
		Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


		Route::resource('/projects',ProjectController::class);
		Route::post('/projects/update/{id}', [ProjectController::class, 'update'])->name('projects.update');
		Route::post('/projects/search/{keyword}', [ProjectController::class, 'search_user'])->name('projects.search_user');
		Route::delete('/del_people', [ProjectController::class, 'destroy']);


		Route::get('/tasks/{id}',[TaskController::class, 'index'])->name('tasks');
		Route::post('/task/update/custom', [TaskController::class,'update'])->name('tasks.update.custom');
		Route::resource('/tasks',TaskController::class);
		Route::resource('/categories',CategoryController::class);
		Route::post('/categories/update_custom', [CategoryController::class, 'update'])->name('categories.update_custom');


	// BEGIN::users
		Route::resource('/users', UserController::class);
		Route::get('/mail', [UserController::class, 'mailshow']);
		Route::post('/users/{id}/update', [UserController::class, 'update'])->name('users.custom_update');
		Route::get('/lst_user', [UserController::class, 'list']);
		Route::delete('/del_user', [UserController::class, 'destroy']);
		Route::post('/invite_member', [UserController::class, 'invite_member'])->name('users.invite_member');
		Route::get('/user/{user}', [UserController::class, 'show_user'])->name('user.view');
	// BEGIN::users

	// BEGIN::roles
		Route::resource('/roles', RoleController::class);
		
		Route::resource('/frameworks', FrameWorkController::class);
		Route::post('/frameworks/update_custom', [FrameworkController::class, 'update'])->name('frameworks.update_custom');
		

		Route::resource('/comments', CommentController::class);
		Route::get('/fetch-new-comments/{timestamp}', [CommentController::class, 'fetchNewComments'])->name('fetchNewComments');

		Route::post('/roles/update/custom', [RoleController::class,'update'])->name('roles.update.custom');
		Route::get('/lst_role', [RoleController::class, 'list']);
		Route::delete('/del_role', [RoleController::class, 'destroy']);
	// BEGIN::roles


});


