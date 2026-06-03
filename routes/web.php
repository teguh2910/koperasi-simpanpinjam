<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Member\DashboardController as MemberDashboard;

// Profile Routes (both admin & member)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'password'])->name('profile.password');
});

// Guest Routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        
        // Member management
        Route::resource('members', \App\Http\Controllers\Admin\MemberController::class);
        
        // Loan Types management
        Route::resource('loan-types', \App\Http\Controllers\Admin\LoanTypeController::class);
        
        // Savings management
        Route::get('savings', [\App\Http\Controllers\Admin\SavingController::class, 'index'])->name('savings.index');
        Route::get('savings/{saving}', [\App\Http\Controllers\Admin\SavingController::class, 'show'])->name('savings.show');
        
        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('index');
            Route::get('/members', [\App\Http\Controllers\Admin\ReportController::class, 'members'])->name('members');
            Route::get('/savings', [\App\Http\Controllers\Admin\ReportController::class, 'savings'])->name('savings');
            Route::get('/loans', [\App\Http\Controllers\Admin\ReportController::class, 'loans'])->name('loans');
            Route::get('/financial', [\App\Http\Controllers\Admin\ReportController::class, 'financial'])->name('financial');
            Route::get('/pnl', [\App\Http\Controllers\Admin\ReportController::class, 'pnl'])->name('pnl');
            Route::get('/profit-data', [\App\Http\Controllers\Admin\ReportController::class, 'profitData'])->name('profit-data');
        });
        
        // Loans management
        Route::get('loans', [\App\Http\Controllers\Admin\LoanController::class, 'index'])->name('loans.index');
        Route::get('loans/{loan}', [\App\Http\Controllers\Admin\LoanController::class, 'show'])->name('loans.show');
        Route::put('loans/{loan}/approve', [\App\Http\Controllers\Admin\LoanController::class, 'approve'])->name('loans.approve');
        Route::put('loans/{loan}/reject', [\App\Http\Controllers\Admin\LoanController::class, 'reject'])->name('loans.reject');
        Route::put('loans/{loan}/disburse', [\App\Http\Controllers\Admin\LoanController::class, 'disburse'])->name('loans.disburse');
        Route::post('loans/{loan}/payments', [\App\Http\Controllers\Admin\LoanController::class, 'storePayment'])->name('loans.payments.store');
        Route::delete('loans/{loan}', [\App\Http\Controllers\Admin\LoanController::class, 'destroy'])->name('loans.destroy');

        // Expenses
        Route::get('expenses', [\App\Http\Controllers\Admin\ExpenseController::class, 'index'])->name('expenses.index');
        Route::post('expenses', [\App\Http\Controllers\Admin\ExpenseController::class, 'store'])->name('expenses.store');
        Route::delete('expenses/{expense}', [\App\Http\Controllers\Admin\ExpenseController::class, 'destroy'])->name('expenses.destroy');

        // SHU
        Route::prefix('shu')->name('shu.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\SHUController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\SHUController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\SHUController::class, 'store'])->name('store');
            Route::get('/{shu_period}', [\App\Http\Controllers\Admin\SHUController::class, 'show'])->name('show');
            Route::get('/{shu_period}/calculate', [\App\Http\Controllers\Admin\SHUController::class, 'calculate'])->name('calculate');
            Route::delete('/{shu_period}', [\App\Http\Controllers\Admin\SHUController::class, 'destroy'])->name('destroy');
        });
    });
});

// Member Routes
Route::middleware(['auth', 'member'])->group(function () {
    Route::prefix('member')->name('member.')->group(function () {
        Route::get('/dashboard', [MemberDashboard::class, 'index'])->name('dashboard');
        
        // Savings
        Route::get('savings', [\App\Http\Controllers\Member\SavingController::class, 'index'])->name('savings.index');
        Route::get('savings/create', [\App\Http\Controllers\Member\SavingController::class, 'create'])->name('savings.create');
        Route::post('savings', [\App\Http\Controllers\Member\SavingController::class, 'store'])->name('savings.store');
        
        // Loans
        Route::get('loans', [\App\Http\Controllers\Member\LoanController::class, 'index'])->name('loans.index');
        Route::get('loans/create', [\App\Http\Controllers\Member\LoanController::class, 'create'])->name('loans.create');
        Route::post('loans', [\App\Http\Controllers\Member\LoanController::class, 'store'])->name('loans.store');
        Route::get('loans/{loan}', [\App\Http\Controllers\Member\LoanController::class, 'show'])->name('loans.show');

        // SHU
        Route::get('shu', [\App\Http\Controllers\Member\SHUController::class, 'index'])->name('shu.index');
    });
});