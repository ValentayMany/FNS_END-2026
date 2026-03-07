<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisteredUserController;

// หน้าแรก → register
Route::get('/', [RegisteredUserController::class, 'create']);

// Dashboard (ทุก role เข้าได้)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// ---- Requester ----
Route::middleware(['auth', 'role:requester'])->group(function () {
    Route::get('/requests', [RequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/create', [RequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [RequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/{advanceRequest}', [RequestController::class, 'show'])->name('requests.show');
    Route::post('/requests/{advanceRequest}/submit', [RequestController::class, 'submit'])->name('requests.submit');
});

// ---- Approvers ----
Route::middleware(['auth', 'role:accountant,head_of_finance,deputy_head_of_faculty,head_of_faculty'])
    ->group(function () {
        Route::get('/approvals', [ApprovalController::class, 'index'])->name('approval.index');
        Route::get('/approvals/{advanceRequest}', [ApprovalController::class, 'show'])->name('approval.show');
        Route::post('/approvals/{advanceRequest}/approve', [ApprovalController::class, 'approve'])->name('approval.approve');
        Route::post('/approvals/{advanceRequest}/reject', [ApprovalController::class, 'reject'])->name('approval.reject');
    });


require __DIR__.'/auth.php';
