<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });




// Route::get('/login', [AuthWebController::class, 'showLogin']);
// Route::post('/login', [AuthWebController::class, 'login'])->name('login.post');

// Route::middleware('auth')->group(function () {

//     Route::get('/dashboard', fn() => view('dashboard'));

//     Route::middleware('role:org_hr,org_admin,super_admin')->group(function () {
//         Route::get('/employees', [EmployeeController::class, 'webIndex']);
//     });

//     Route::middleware('role:org_sales,org_admin,super_admin')->group(function () {
//         Route::get('/leads', [LeadController::class, 'webIndex']);
//     });
// });

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\AuthWebController;

Route::get('/', fn() => redirect('/login'));


Route::get('/login', [AuthWebController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthWebController::class, 'login'])->name('login.post');

Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
Route::middleware(['auth', 'role:org_hr,org_admin,super_admin'])
    ->group(function () {
        Route::resource('employees', EmployeeController::class)
            ->only(['index', 'create', 'store', 'show']);
    });

// Route::middleware(['auth', 'role:org_sales,org_admin,super_admin'])
//     ->group(function () {
//         Route::resource('leads', LeadController::class)
//             ->only(['index', 'create', 'store', 'show']);
//     });

Route::middleware(['auth', 'role:org_sales,org_admin,super_admin'])->group(function () {
    Route::resource('leads', LeadController::class)
        ->only(['index', 'create', 'store', 'show']);
});


Route::post('/logout', function () {
    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
})->name('logout');
