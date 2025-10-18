<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\CollegeAdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ReviewerController;
use App\Http\Controllers\CertificateController;
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/', function () { return view('welcome'); });

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// SUPER ADMIN ROUTES
Route::middleware(['auth', 'role:super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    // Institute Management
    Route::get('/colleges', [SuperAdminController::class, 'listColleges'])->name('colleges.index');
    Route::get('/colleges/create', [SuperAdminController::class, 'createInstitute'])->name('colleges.create');
    Route::post('/colleges', [SuperAdminController::class, 'storeInstitute'])->name('colleges.store');
    Route::get('/colleges/{institute}/edit', [SuperAdminController::class, 'editInstitute'])->name('colleges.edit');
    Route::put('/colleges/{institute}', [SuperAdminController::class, 'updateInstitute'])->name('colleges.update');
    Route::delete('/colleges/{institute}', [SuperAdminController::class, 'destroyInstitute'])->name('colleges.destroy');
    // User Management
    Route::get('/users', [SuperAdminController::class, 'listUsers'])->name('users.index');
    Route::get('/users/create', [SuperAdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [SuperAdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [SuperAdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [SuperAdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [SuperAdminController::class, 'destroyUser'])->name('users.destroy');
    // Submission Management
    Route::get('/submissions', [SuperAdminController::class, 'listSubmissions'])->name('submissions.index');
    Route::patch('/submissions/{submission}/assign', [SuperAdminController::class, 'assignReviewer'])->name('submissions.assign');
});

// COLLEGE ADMIN ROUTES
Route::middleware(['auth', 'role:college_admin'])->prefix('college')->name('college.')->group(function () {
    Route::get('/students/pending', [CollegeAdminController::class, 'listPendingStudents'])->name('students.pending');
    Route::patch('/students/{user}/approve', [CollegeAdminController::class, 'approveStudent'])->name('students.approve');
});

// STUDENT ROUTES
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/submission/create', [StudentController::class, 'createSubmission'])->name('submission.create');
    Route::post('/submission', [StudentController::class, 'storeSubmission'])->name('submission.store');
    Route::get('/submission/{submission}/certificate', [CertificateController::class, 'downloadCertificate'])->name('submission.certificate');
});

// REVIEWER ROUTES
Route::middleware(['auth', 'role:reviewer'])->prefix('reviewer')->name('reviewer.')->group(function () {
    Route::get('/submission/{submission}', [ReviewerController::class, 'showSubmission'])->name('submission.show');
    Route::post('/submission/{submission}/feedback', [ReviewerController::class, 'storeFeedback'])->name('submission.feedback');
});
