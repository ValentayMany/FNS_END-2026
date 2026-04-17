<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ClearingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\TreasurerController;
use App\Http\Controllers\TreasuryController;
use Illuminate\Support\Facades\Route;

// หน้าแรก
Route::get('/', [RegisteredUserController::class, 'create']);

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')->name('dashboard');

// ---- Requester ----
Route::middleware(['auth', 'role:requester'])->group(function () {
    Route::get('/requests', [RequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/create', [RequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [RequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/{advanceRequest}', [RequestController::class, 'show'])->name('requests.show');
    Route::post('/requests/{advanceRequest}/submit', [RequestController::class, 'submit'])->name('requests.submit');

    // Clearing
    Route::get('/clearing', [ClearingController::class, 'index'])->name('clearing.index');
    Route::post('/clearing/{advanceRequest}/submit', [ClearingController::class, 'submit'])->name('clearing.submit');
    Route::get('/clearing/attachment/{attachment}/download', [ClearingController::class, 'downloadAttachment'])->name('clearing.attachment.download');
});

// ---- Approvers ----
Route::middleware(['auth', 'role:accountant,head_of_finance,deputy_head_of_faculty,head_of_faculty'])
    ->group(function () {
        Route::get('/approvals', [ApprovalController::class, 'index'])->name('approval.index');
        Route::get('/approvals/{advanceRequest}', [ApprovalController::class, 'show'])->name('approval.show');
        Route::post('/approvals/{advanceRequest}/approve', [ApprovalController::class, 'approve'])->name('approval.approve');
        Route::post('/approvals/{advanceRequest}/reject', [ApprovalController::class, 'reject'])->name('approval.reject');
    });

// ---- Accountant เพิ่มเติม (Confirm Clearing + บันทึกรายจ่าย) ----
Route::middleware(['auth', 'role:accountant'])->group(function () {
    Route::get('/clearing/pending', [ClearingController::class, 'pendingIndex'])->name('clearing.pending');
    Route::post('/clearing/{advanceRequest}/confirm', [ClearingController::class, 'confirm'])->name('clearing.confirm');

    Route::get('/expense', [ExpenseController::class, 'index'])->name('expense.index');
    Route::post('/expense', [ExpenseController::class, 'store'])->name('expense.store');
});

// ---- Cashier ----
Route::middleware(['auth', 'role:cashier'])->group(function () {
    Route::get('/cashier', [CashierController::class, 'index'])->name('cashier.index');
    Route::post('/cashier/{advanceRequest}/pay', [CashierController::class, 'pay'])->name('cashier.pay');
});

// ---- Revenue Officer ----
Route::middleware(['auth', 'role:revenue_officer'])->group(function () {
    Route::get('/revenue', [RevenueController::class, 'index'])->name('revenue.index');
    Route::post('/revenue', [RevenueController::class, 'store'])->name('revenue.store');
});

// ---- Treasurer ----
Route::middleware(['auth', 'role:treasurer'])->group(function () {
    Route::get('/treasurer', [TreasurerController::class, 'index'])->name('treasurer.index');
});

// ---- Admin ----
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::patch('/admin/users/{user}/role', [AdminController::class, 'updateRole'])->name('admin.users.role');
});

// ---- Treasury Reconciliation ----
Route::middleware(['auth', 'role:treasury_reconciliation_officer'])->group(function () {
    Route::get('/treasury', [TreasuryController::class, 'index'])->name('treasury.index');
    Route::post('/treasury', [TreasuryController::class, 'store'])->name('treasury.store');
});

Route::middleware(['auth', 'role:admin,accountant,head_of_finance,deputy_head_of_faculty,head_of_faculty,treasurer,revenue_officer'])
    ->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    });

require __DIR__.'/auth.php';
