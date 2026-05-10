<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AdminStationController as AdminStationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\HotlineController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\SettingController;


Auth::routes();


Route::get('/healthz', function () {
    return response()->json(['status' => 'ok']);
});

// Profile routes – accessible to all authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin routes – only users with role 'admin'
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminReportController::class, 'index'])->name('dashboard');
    Route::get('/reports/export', [AdminReportController::class, 'export'])->name('reports.export');
    Route::get('/reports/{report}', [AdminReportController::class, 'show'])->name('reports.show');
    Route::put('/reports/{report}', [AdminReportController::class, 'update'])->name('reports.update');
    Route::resource('users', AdminUserController::class);
    Route::resource('stations', AdminStationController::class)->except(['show']);
    Route::post('/stations/{station}/send-alert/{report}', [AdminStationController::class, 'sendAlert'])->name('stations.sendAlert'); // note: was admin.stations.sendAlert

    // New admin pages
    Route::get('/notifications', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications');
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs');
    Route::resource('hotlines', App\Http\Controllers\Admin\HotlineController::class)->except(['show'])->names('hotlines');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');   
});

// Public home page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Citizen routes – only users with role 'citizen'
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':citizen'])->group(function () {
    Route::get('/dashboard', [ReportController::class, 'index'])->name('dashboard');
    Route::resource('reports', ReportController::class)->except(['edit', 'update', 'destroy']);
    Route::get('/report-tracker', [ReportController::class, 'tracker'])->name('citizen.tracker');   
});

// Citizen additional pages
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('citizen.notifications');
    Route::get('/emergency-hotlines', [HotlineController::class, 'index'])->name('citizen.hotlines');
    
});