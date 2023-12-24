<?php

use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('Auth/Login');
});

Route::get('/dashboard', function () {
    if(auth()->user()->is_admin){
        return view('dashboard');
    }
    else{
        return redirect()->route('staff.show', auth()->user()->staff);
    }
    
})->name('dashboard');

Route::middleware(['auth', 'verified', 'admin'])->group(function(){
    Route::get('/company-hours', [CompaniesController::class, 'index'])->name('companies.index');
    Route::get('/companies', [CompaniesController::class, 'show'])->name('companies.show');

    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::get('/staff/{staff}', function($staff){
    //     dd($staff);
    // })->name('dummy');

    Route::get('/staff/{staff}', [StaffController::class, 'show'])->name('staff.show')->middleware('staff.owner');
});

require __DIR__.'/auth.php';
