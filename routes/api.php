<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeadController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {

    Route::middleware(['role:org_hr,org_admin,super_admin', 'org'])->group(function () {
        Route::get('/employees', [EmployeeController::class, 'index']);
        Route::post('/employees', [EmployeeController::class, 'store']);
        Route::get('/employees/{id}', [EmployeeController::class, 'show']);
    });

    Route::middleware(['role:org_sales,org_admin,super_admin', 'org'])->group(function () {
        Route::get('/leads', [LeadController::class, 'index']);
        Route::post('/leads', [LeadController::class, 'store']);
        Route::get('/leads/{id}', [LeadController::class, 'show']);
    });
});
