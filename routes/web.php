<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApprovalController;
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

Route::get('/', fn () => redirect()->route('login'));

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// ---- Requester ----
Route::middleware(['auth', 'role:requester'])
    ->group(function () {
        Route::get('/requests', [RequestController::class, 'index'])->name('requests.index');
        Route::get('/requests/create', [RequestController::class, 'create'])->name('requests.create');
        Route::post('/requests', [RequestController::class, 'store'])->name('requests.store');
        Route::get('/requests/{advanceRequest}', [RequestController::class, 'show'])->name('requests.show');
        Route::get('/requests/{advanceRequest}/edit', [RequestController::class, 'edit'])->name('requests.edit');
        Route::put('/requests/{advanceRequest}', [RequestController::class, 'update'])->name('requests.update');
        Route::delete('/requests/{advanceRequest}', [RequestController::class, 'destroy'])->name('requests.destroy');
        Route::post('/requests/{advanceRequest}/submit', [RequestController::class, 'submit'])->name('requests.submit');
    });

// ---- Approval  ----
Route::middleware(['auth', 'role:accountant,head_of_finance,deputy_head_of_faculty,head_of_faculty'])
    ->group(function () {
        Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');
        Route::get('/approvals/{advanceRequest}', [ApprovalController::class, 'show'])->name('approvals.show');
        Route::post('/approvals/{advanceRequest}/approve', [ApprovalController::class, 'approve'])->name('approvals.approve');
        Route::post('/approvals/{advanceRequest}/reject',  [ApprovalController::class, 'reject'])->name('approvals.reject');
    });

// ---- Cashier ----
Route::middleware(['auth', 'role:cashier'])
    ->group(function () {
        Route::get('/cashier', [CashierController::class, 'index'])->name('cashier.index');
        Route::post('/cashier/{advanceRequest}/pay', [CashierController::class, 'pay'])->name('cashier.pay');
    });

// ---- Clearing (Requester) ----
Route::middleware(['auth', 'role:requester'])
    ->group(function () {
        Route::get('/clearing', [ClearingController::class, 'index'])->name('clearing.index');
        Route::post('/clearing/{advanceRequest}/submit', [ClearingController::class, 'submit'])->name('clearing.submit');
    });

// ---- Clearing (Accountant) ----
Route::middleware(['auth', 'role:accountant'])
    ->group(function () {
        Route::get('/clearing/pending', [ClearingController::class, 'pendingIndex'])->name('clearing.pending');
        Route::post('/clearing/{advanceRequest}/confirm', [ClearingController::class, 'confirm'])->name('clearing.confirm');
    });
Route::middleware(['auth'])->group(function () {
    Route::get('/clearing-attachment/{attachment}/download', [ClearingController::class, 'downloadAttachment'])->name('clearing.download');
});

// ---- Revenue (Revenue Officer only) ----
Route::middleware(['auth', 'role:revenue_officer'])
    ->group(function () {
        Route::get('/revenue', [RevenueController::class, 'index'])->name('revenue.index');
        Route::post('/revenue', [RevenueController::class, 'store'])->name('revenue.store');
        Route::get('/revenue/{transaction}/edit', [RevenueController::class, 'edit'])->name('revenue.edit');
        Route::put('/revenue/{transaction}', [RevenueController::class, 'update'])->name('revenue.update');
        Route::delete('/revenue/{transaction}', [RevenueController::class, 'destroy'])->name('revenue.destroy');
    });

// ---- Expense (Accountant only) ----
Route::middleware(['auth', 'role:accountant'])
    ->group(function () {
        Route::get('/expense', [ExpenseController::class, 'index'])->name('expense.index');
        Route::get('/expense/next-code', [ExpenseController::class, 'getNextCode'])->name('expense.next-code');
        Route::post('/expense', [ExpenseController::class, 'store'])->name('expense.store');
        Route::get('/expense/{transaction}/edit', [ExpenseController::class, 'edit'])->name('expense.edit');
        Route::put('/expense/{transaction}', [ExpenseController::class, 'update'])->name('expense.update');
        Route::delete('/expense/{transaction}', [ExpenseController::class, 'destroy'])->name('expense.destroy');
    });

// ---- Treasurer ----
Route::middleware(['auth', 'role:treasurer'])
    ->group(function () {
        Route::get('/treasurer', [TreasurerController::class, 'index'])->name('treasurer.index');
    });

// ---- Treasury Reconciliation ----
Route::middleware(['auth', 'role:treasury_reconciliation_officer'])
    ->group(function () {
        Route::get('/treasury', [TreasuryController::class, 'index'])->name('treasury.index');
        Route::post('/treasury/reconcile', [TreasuryController::class, 'store'])->name('treasury.reconcile');
    });

// ---- Admin ----
Route::middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
        Route::post('/admin/users/{user}/update-role', [AdminController::class, 'updateRole'])->name('admin.updateRole');
        Route::post('/admin/users/{user}/toggle-active', [AdminController::class, 'toggleActive'])->name('admin.toggleActive');
    });

// ---- Reports ----
Route::middleware(['auth', 'role:admin,accountant,head_of_finance,deputy_head_of_faculty,head_of_faculty,treasurer,revenue_officer'])
    ->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
        Route::get('/reports/budget-expense', [\App\Http\Controllers\BudgetExpenseReportController::class, 'index'])->name('reports.budget-expense');
    });

require __DIR__ . '/auth.php';
