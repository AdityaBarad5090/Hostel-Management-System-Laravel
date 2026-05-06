<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminAuth;

Route::get('/fees', [FeeController::class, 'index'])->name('fees.index');
Route::post('/fees', [FeeController::class, 'store'])->name('fees.store');
Route::put('/fees/{id}', [FeeController::class, 'update'])->name('fees.update');
Route::delete('/fees/{id}', [FeeController::class, 'destroy'])->name('fees.destroy');
Route::post('/fees/{id}/remind', [FeeController::class, 'sendReminder'])->name('fees.remind');
Route::resource('fees', FeeController::class);

Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
Route::put('/rooms/{id}', [RoomController::class, 'update'])->name('rooms.update');
Route::delete('/rooms/{id}', [RoomController::class, 'destroy'])->name('rooms.destroy');

Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::post('/students', [StudentController::class, 'store'])->name('students.store');
Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
Route::put('/complaints/{id}', [ComplaintController::class, 'update'])->name('complaints.update');
Route::delete('/complaints/{id}', [ComplaintController::class, 'destroy'])->name('complaints.destroy');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout']);

Route::middleware(AdminAuth::class)->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/students', [StudentController::class, 'index']);
    Route::get('/rooms', [RoomController::class, 'index']);
    Route::get('/fees', [FeeController::class, 'index']);
    Route::get('/complaints', [ComplaintController::class, 'index']);
});

Route::get('/', function () {
    return view('index');
});

Route::get('/admin/login', function () {
    return view('admin-login');
});

Route::get('/student/login', function () {
    return view('student-login');
});

Route::post('/student/login', [StudentController::class, 'login']);
Route::get('/student/dashboard', [StudentController::class, 'dashboard']);
Route::get('/student/room', [StudentController::class, 'room']);
Route::get('/student/fees', [StudentController::class, 'fees']);
Route::get('/student/complaint', [StudentController::class, 'complaint']);
Route::post('/student/complaint', [StudentController::class, 'storeComplaint']);
Route::get('/student/fees/receipt/{id}', [StudentController::class, 'recipt']);
Route::get('/student/fees/pay/{id}',     [StudentController::class, 'payFees']);
Route::get('/student/fees/success/{id}', [StudentController::class, 'paySuccess']);


Route::get('/student/logout', [StudentController::class, 'logout']);

Route::middleware(['studentAuth'])->group(function () {

    Route::get('/student/dashboard', [StudentController::class, 'dashboard']);
    Route::get('/student/room', [StudentController::class, 'room']);
    Route::post('/student/complaint', [StudentController::class, 'storeComplaint']);
    Route::get('/student/logout', [StudentController::class, 'logout']);
});
