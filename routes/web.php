<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AdminController;  
use App\Http\Controllers\AdminUserController;


use App\Http\Controllers\SmsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
/*Route::get('/', function () {
    return view('login');
});*/

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/lesson', function () {
    return view('lesson');
});

Route::get('/pupils', function () {
    return view('pupils');
});

Route::get('/activity', function () {
    return view('activity');
});

Route::get('/reward', function () {
    return view('reward');
});

Route::get('/dummy', function () {
    return view('dummy');
});
// Route::get('/student_dashboard', function () {
//     return view('student_dashboard');
// });

Route::get('/pupils_lesson', function () {
    return view('pupils_lesson');
});


Route::get('/admin_register', function () {
    return view('admin_register');
});





Route::controller(AuthController::class)->group(function () {
    Route::get('register','register')->name('register');
    Route::post('register','registerSave')->name('register_save');

    Route::get('login', 'login')->name('login');
    Route::post('login','loginAction')->name('login_action');

    Route::get('logout','logout')->middleware('auth')->name('logout');

    
});



Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    Route::get('/admin/bookings/{bookingId}/messages', [AdminController::class, 'showBookingMessages'])->name('admin.booking.messages');
    Route::get('/admin/deleted-bookings/messages', [AdminController::class, 'showDeletedBookingMessages'])->name('admin.deletedBooking.messages');
    Route::get('/admin/deleted-bookings/messages', [AdminController::class, 'showDeletedBookingMessages'])->name('admin.showDeletedMessages');

    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');

    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');

    
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');




});


Route::middleware(['auth', 'teacher'])->group(function () {
    Route::get('teacherDashboard', function () {return view('teacher_dashboard');})->name('teacherDashboard'); 

    Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');
    Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
    Route::get('/schedules/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
    Route::put('/schedules/{schedule}', [ScheduleController::class, 'update'])->name('schedules.update');
    Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');

    Route::get('/teacher-bookings', [BookingController::class, 'viewTeacherBookings'])->name('bookings.teacherBookings');
    Route::post('/bookings/{booking}/update-status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');

    
});


Route::middleware('auth')->group(function () {
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/messages', [BookingController::class, 'getMessages'])->name('bookings.getMessages');

    Route::get('/messages', [MessageController::class, 'index'])->name('message.index');
    Route::post('/messages', [MessageController::class, 'store'])->name('message.store');
});


Route::middleware(['auth', 'student'])->group(function () {
    Route::get('studentDashboard', function () {return view('student_dashboard');})->name('student_dashboard');

    Route::get('/view-teachers', [StudentController::class, 'viewTeachers'])->name('students.viewTeachers');
    Route::get('/bookings/create/{schedule}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/student-bookings', [BookingController::class, 'viewStudentBookings'])->name('bookings.studentBookings');

    
});





Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');






// Route::middleware('auth')->group(function () {
    

//     //route for teacher dashboard functions

// });

// Route::controller(ClassController::class)->prefix('teacher_dashboard')->group(function () {
//         Route::get('class','class')->name('teacher_dashboard.class');
//         Route::post('classStore','classStore')->name('teacher_dashboard.classStore');
    
//         Route::get('pupil','pupil')->name('teacher_dashboard.pupil');
//     });


    // });



//Teachers Dashboard end


// pupil auth login start



    // Route::get('/student_dashboard', function () {
    //     return view('student_dashboard');
    // });


    //sms routes

    route::get("/sendsms", [SmsController::class,'sendsms']);
    Route::get('/test-sms', [RewardController::class, 'testSmsFunctionality']);



    Route::get("/forget-password", [ForgetPasswordManager::class, "forgetPassword"])->name("forget.password");
    Route::post("/forget-password", [ForgetPasswordManager::class, "forgetPasswordPost"])->name("forget.password.post");
    Route::get("/reset-password/{token}", [ForgetPasswordManager::class, "resetPassword"])->name("reset.password");
    Route::post("/reset-password", [ForgetPasswordManager::class, "resetPasswordPost"])->name("reset.password.post");
