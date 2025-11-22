<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\JobTitleController;
use App\Http\Controllers\MasterDataCategoryController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\OfficeLocationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PublicHolidayController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuditLogController;
use Illuminate\Support\Facades\Route;

// Public Support Route (accessible without authentication)
Route::get('/support', function () {
    return view('support');
})->name('support.public');

// Public Documentation Route (accessible without authentication)
Route::get('/documentation', function () {
    return view('documentation');
})->name('documentation.public');

// Public Version Information Route (accessible without authentication)
Route::get('/version', function () {
    return view('version');
})->name('version.info');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        // Check if user is admin and redirect to appropriate dashboard
        if (auth()->user()->isAdmin()) {
            return view('dashboards.admin');
        }
        return view('dashboards.user');
    })->name('dashboard');

    // Profile Routes
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/avatar', [App\Http\Controllers\ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::delete('/profile/avatar', [App\Http\Controllers\ProfileController::class, 'removeAvatar'])->name('profile.avatar.remove');
    Route::get('/profile/security', [App\Http\Controllers\ProfileController::class, 'security'])->name('profile.security');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('/profile/settings', [App\Http\Controllers\ProfileController::class, 'settings'])->name('profile.settings');
    Route::put('/profile/settings', [App\Http\Controllers\ProfileController::class, 'updateSettings'])->name('profile.settings.update');

    // Master Data Management Routes
    Route::resource('master-data-categories', MasterDataCategoryController::class);
    Route::get('master-data-categories-import', [MasterDataCategoryController::class, 'showImport'])->name('master-data-categories.import');
    Route::post('master-data-categories-import', [MasterDataCategoryController::class, 'import'])->name('master-data-categories.import.process');
    Route::get('master-data-categories-template', [MasterDataCategoryController::class, 'downloadTemplate'])->name('master-data-categories.template');
    
    Route::resource('master-data', MasterDataController::class);
    Route::get('master-data-import', [MasterDataController::class, 'showImport'])->name('master-data.import');
    Route::post('master-data-import', [MasterDataController::class, 'import'])->name('master-data.import.process');
    Route::get('master-data-template', [MasterDataController::class, 'downloadTemplate'])->name('master-data.template');
    
    Route::resource('departments', DepartmentController::class);
    Route::get('departments-import', [DepartmentController::class, 'showImport'])->name('departments.import');
    Route::post('departments-import', [DepartmentController::class, 'import'])->name('departments.import.process');
    Route::get('departments-template', [DepartmentController::class, 'downloadTemplate'])->name('departments.template');
    
    Route::resource('job-titles', JobTitleController::class);
    Route::get('job-titles-import', [JobTitleController::class, 'showImport'])->name('job-titles.import');
    Route::post('job-titles-import', [JobTitleController::class, 'import'])->name('job-titles.import.process');
    Route::get('job-titles-template', [JobTitleController::class, 'downloadTemplate'])->name('job-titles.template');
    
    Route::resource('office-locations', OfficeLocationController::class);
    Route::get('office-locations-import', [OfficeLocationController::class, 'showImport'])->name('office-locations.import');
    Route::post('office-locations-import', [OfficeLocationController::class, 'import'])->name('office-locations.import.process');
    Route::get('office-locations-template', [OfficeLocationController::class, 'downloadTemplate'])->name('office-locations.template');

    // RBAC Routes
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('modules', ModuleController::class);

    // User Management Routes
    Route::resource('users', UserController::class);
    Route::get('users-import', [UserController::class, 'showImport'])->name('users.import');
    Route::post('users-import', [UserController::class, 'import'])->name('users.import.process');
    Route::get('users-template', [UserController::class, 'downloadTemplate'])->name('users.template');

    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Reports Routes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/users', [ReportController::class, 'users'])->name('reports.users');
    Route::get('/reports/roles-permissions', [ReportController::class, 'rolesPermissions'])->name('reports.roles-permissions');
    Route::get('/reports/departments', [ReportController::class, 'departments'])->name('reports.departments');
    Route::get('/reports/user-activity', [ReportController::class, 'userActivity'])->name('reports.user-activity');
    Route::get('/reports/summary', [ReportController::class, 'summary'])->name('reports.summary');

    // Audit Log Routes
    Route::middleware('permission:audit-logs-view')->group(function () {
        Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
        Route::get('/audit-logs/{id}', [AuditLogController::class, 'show'])->name('audit-logs.show');
        Route::get('/audit-logs-model', [AuditLogController::class, 'forModel'])->name('audit-logs.model');
        Route::get('/audit-logs-statistics', [AuditLogController::class, 'statistics'])->name('audit-logs.statistics');
    });
    
    Route::delete('/audit-logs-clear', [AuditLogController::class, 'clear'])
        ->name('audit-logs.clear')
        ->middleware('permission:audit-logs-clear');

    // Public Holidays Routes
    Route::resource('public-holidays', PublicHolidayController::class);

    Route::get('/gate', function () {
    return view('gate');
    })->name('gate');
    
    Route::get('/issuing', function () {
        return view('issuing');
    })->name('issuing'); 
    Route::get('/rejection', function () {
        return view('rejection');
    })->name('rejection');

    Route::get('/cash_voucher', function () {
        return view('cash_voucher');
    })->name('cash_voucher');

    Route::get('/receive', function () {
        return view('receive');
    })->name('receive');

    
    Route::get('/material_return', function () {
        return view('material_return');
    })->name('material_return');
});


