<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\DisbursementController;




Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// Student APIs
Route::middleware(['auth:sanctum', 'role:student'])->group(function () {
    Route::get('/scholarships', [ScholarshipController::class, 'index']);
    Route::post('/applications', [ApplicationController::class, 'store']);
    Route::post('/applications/{id}/documents', [ApplicationController::class, 'uploadDocument']);
    Route::get('/my-applications', [ApplicationController::class, 'myApplications']);
    Route::get('/applications/{id}', [ApplicationController::class, 'show']);
    Route::get('/applications/{id}/logs', [ApplicationController::class, 'logs']);
    Route::get('/my-awards', [AwardController::class, 'myAwards']);
    Route::get('/awards/{awardId}/disbursements', [DisbursementController::class, 'awardDisbursements']);
    Route::post('/disbursements/{id}/receipts', [DisbursementController::class, 'uploadReceipt']);
    Route::get('/disbursements/{id}', [DisbursementController::class, 'show']);
});

// Admin APIs
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/scholarships', [ScholarshipController::class, 'store']);
    Route::put('/scholarships/{id}', [ScholarshipController::class, 'update']);
    Route::delete('/scholarships/{id}', [ScholarshipController::class, 'destroy']);
    Route::get('/admin/applications', [ApplicationController::class, 'allApplications']);
    Route::get('/admin/applications/{id}', [ApplicationController::class, 'adminShow']);
    Route::post('/admin/applications/{id}/review', [ApplicationController::class, 'review']);
    Route::post('/admin/cost-categories', [AwardController::class, 'storeCategory']);
    Route::get('/admin/cost-categories', [AwardController::class, 'listCategories']);
    Route::post('/admin/scholarships/{id}/budgets', [AwardController::class, 'setBudgets']);
    Route::get('/admin/scholarships/{id}/budgets', [AwardController::class, 'viewBudgets']);
    Route::post('/admin/applications/{id}/award', [AwardController::class, 'createAward']);
    Route::post('/admin/awards/{awardId}/schedules', [DisbursementController::class, 'createSchedule']);
    Route::post('/admin/disbursements/{id}/pay', [DisbursementController::class, 'pay']);
    Route::get('/admin/disbursements', [DisbursementController::class, 'filter']);
    Route::post('/admin/receipts/{id}/verify', [DisbursementController::class, 'verifyReceipt']);
    Route::get('/admin/reports/scholarships/{id}', [AwardController::class, 'scholarshipReport']);
    Route::get('/admin/reports/awards/{awardId}', [AwardController::class, 'awardReport']);
});
