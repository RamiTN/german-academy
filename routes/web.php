<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\ApplyController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/apply', [ApplyController::class, 'index'])->name('apply')->middleware('auth');
Route::post('/apply', [ApplyController::class, 'store'])->name('apply.store')->middleware('auth');
Route::get('/how-it-works', fn() => view('public.how-it-works'))->name('how-it-works');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/dashboard', function () {
    return redirect()->route('home'); // Redirects to proper dashboard based on role
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/students', fn() => view('admin.students.index'))->name('students.index');
    Route::get('/teachers', fn() => view('admin.teachers.index'))->name('teachers.index');
    Route::get('/applications', fn() => view('admin.applications.index'))->name('applications.index');
    Route::get('/schedules', fn() => view('admin.schedules.index'))->name('schedules.index');
    Route::get('/announcements', fn() => view('admin.announcements.index'))->name('announcements.index');
    Route::get('/homework', fn() => view('admin.homework.index'))->name('homework.index');
    Route::get('/quizzes', fn() => view('admin.quizzes.index'))->name('quizzes.index');
    Route::get('/tests', fn() => view('admin.tests.index'))->name('tests.index');
    Route::get('/resources', fn() => view('admin.resources.index'))->name('resources.index');
    Route::get('/settings', fn() => view('admin.settings.index'))->name('settings.index');
    Route::get('/logs', fn() => view('admin.logs.index'))->name('logs.index');
});

// Teacher Routes
Route::prefix('teacher')->middleware(['auth', 'role:teacher'])->name('teacher.')->group(function () {
    Route::get('/', [TeacherDashboardController::class, 'index'])->name('dashboard');
    Route::get('/students', fn() => view('teacher.students.index'))->name('students.index');
    Route::delete('/students/{student}', [App\Http\Controllers\Teacher\StudentController::class, 'destroy'])->name('students.destroy');
    Route::get('/applications', [App\Http\Controllers\Teacher\ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}/edit', [App\Http\Controllers\Teacher\ApplicationController::class, 'edit'])->name('applications.edit');
    Route::put('/applications/{application}', [App\Http\Controllers\Teacher\ApplicationController::class, 'update'])->name('applications.update');
    Route::get('/homework', fn() => view('teacher.homework.index'))->name('homework.index');
    Route::get('/quizzes', fn() => view('teacher.quizzes.index'))->name('quizzes.index');
    Route::get('/tests', fn() => view('teacher.tests.index'))->name('tests.index');
    Route::get('/announcements', fn() => view('teacher.announcements.index'))->name('announcements.index');
    Route::get('/resources', fn() => view('teacher.resources.index'))->name('resources.index');
});

// Student Routes
Route::prefix('student')->middleware(['auth', 'role:student'])->name('student.')->group(function () {
    Route::get('/', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/homework', fn() => view('student.homework.index'))->name('homework.index');
    Route::get('/quizzes', fn() => view('student.quizzes.index'))->name('quizzes.index');
    Route::get('/tests', fn() => view('student.tests.index'))->name('tests.index');
    Route::get('/resources', fn() => view('student.resources.index'))->name('resources.index');
    Route::get('/grades', fn() => view('student.grades.index'))->name('grades.index');
    Route::get('/attendance', fn() => view('student.attendance.index'))->name('attendance.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Language switcher
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'ar', 'fr'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

