<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LetterTypeController;
use App\Models\LetterType;

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

Route::get('/error-permission', function () {
    return view('errors.permission');
})->name('error.permission');



Route::middleware('IsGuest')->group(function () {
    Route::get('/', function () {
        return view('login');
    })->name('login');
    Route::post('/', [UserController::class, 'loginAuth'])->name('login.auth');
});



Route::get('/logout', [UserController::class, 'logout'])->name('logout');



Route::middleware(['IsLogin', 'IsGuru'])->group(function () {
    Route::prefix('/guru')->name('guru.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
    });



});









Route::middleware(['IsLogin', 'IsStaff'])->group(function () {


    Route::prefix('/staff')->name('staff.')->group(function () {
        Route::get('/', [StaffController::class, 'index'])->name('index');
    });

    Route::prefix('/user')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::patch('update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete');
    });


    Route::prefix('/klasifikasi')->name('klasifikasi.')->group(function () {
        Route::get('/', [LetterTypeController::class, 'index'])->name('index');
        Route::post('/store', [LetterTypeController::class, 'store'])->name('store');
        Route::get('/create', [LetterTypeController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [LetterTypeController::class, 'edit'])->name('edit');
        Route::patch('update/{id}', [LetterTypeController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [LetterTypeController::class, 'destroy'])->name('delete');
        Route::get('/download-excel', [LetterTypeController::class, 'downloadExcel'])->name('download-excel');
        Route::get('/detail{letter_code}', [LetterTypeController::class, 'show'])->name('detail');

    });


    Route::prefix('/letter')->name('letter.')->group(function () {
        Route::get('/', [LetterController::class, 'index'])->name('index');
        Route::post('/store', [LetterController::class, 'store'])->name('store');
        Route::get('/create', [LetterController::class, 'create'])->name('create');
        Route::get('/edit{id}', [LetterController::class, 'edit'])->name('edit');
        Route::patch('/update{id}', [LetterController::class, 'update'])->name('update');
        Route::get('/show{id}', [LetterController::class, 'show'])->name('show');
        Route::get('/download-pdf{id}', [LetterController::class, 'downloadPDF'])->name('download-pdf');



    });

    Route::prefix('/guru')->name('guru.')->group(function () {
        Route::get('/', [GuruController::class, 'index'])->name('index');
        // Route::get('/', [LetterController::class, 'index'])->name('index');

    });
});






// LOGOUT
Route::middleware(['IsLogin'])->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/home', function () {
        return view('home');
    })->name('home.page');
});
