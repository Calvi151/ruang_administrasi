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
    if (auth()->check()) {
        $role = auth()->user()->role;
        return redirect($role === 'admin' ? '/admin/dashboard' : '/ceo/dashboard');
    }
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    // Admin Routes
    Route::middleware('role.admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        
        Route::post('/incoming-letters/ocr', [IncomingLetterController::class, 'extractOcr'])->name('incoming-letters.ocr');
        Route::resource('/incoming-letters', IncomingLetterController::class);
        Route::get('/outgoing-letters/{outgoingLetter}/export-pdf', [OutgoingLetterController::class, 'exportPdf'])->name('outgoing-letters.export-pdf');
        Route::get('/outgoing-letters/{outgoingLetter}/export-word', [OutgoingLetterController::class, 'exportWord'])->name('outgoing-letters.export-word');
        Route::resource('/outgoing-letters', OutgoingLetterController::class);
        Route::resource('/letter-types', LetterTypeController::class);
        Route::resource('/employees', EmployeeController::class);
        Route::resource('/users', UserController::class);
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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
