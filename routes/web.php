<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\IncomingLetterController;
use App\Http\Controllers\Admin\OutgoingLetterController;
use App\Http\Controllers\Admin\LetterTypeController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Ceo\DashboardController as CeoDashboardController;
use App\Http\Controllers\Ceo\LetterApprovalController;
use App\Http\Controllers\Ceo\ReadonlyController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Admin Routes
    Route::middleware('role.admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        
        Route::apiResource('/incoming-letters', IncomingLetterController::class);
        Route::apiResource('/outgoing-letters', OutgoingLetterController::class);
        Route::apiResource('/letter-types', LetterTypeController::class);
        Route::apiResource('/employees', EmployeeController::class);
        Route::apiResource('/users', UserController::class);
    });

    // CEO Routes
    Route::middleware('role.ceo')->prefix('ceo')->group(function () {
        Route::get('/dashboard', [CeoDashboardController::class, 'index'])->name('ceo.dashboard');
        
        Route::get('/letter-approvals', [LetterApprovalController::class, 'index']);
        Route::get('/letter-approvals/{outgoingLetter}', [LetterApprovalController::class, 'show']);
        Route::post('/letter-approvals/{outgoingLetter}/approve', [LetterApprovalController::class, 'approve']);
        Route::post('/letter-approvals/{outgoingLetter}/reject', [LetterApprovalController::class, 'reject']);

        Route::get('/incoming-letters', [ReadonlyController::class, 'incomingLetters']);
        Route::get('/outgoing-letters', [ReadonlyController::class, 'outgoingLetters']);
        Route::get('/employees', [ReadonlyController::class, 'employees']);
    });
});

require __DIR__.'/auth.php';
