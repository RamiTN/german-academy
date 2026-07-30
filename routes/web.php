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
    
    // Applications
    Route::get('/applications', [\App\Http\Controllers\Admin\ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}/edit', [\App\Http\Controllers\Admin\ApplicationController::class, 'edit'])->name('applications.edit');
    Route::put('/applications/{application}', [\App\Http\Controllers\Admin\ApplicationController::class, 'update'])->name('applications.update');

    Route::get('/schedules', [\App\Http\Controllers\MeetingController::class, 'index'])->name('schedules.index');
    
    // Announcements
    Route::get('/announcements', [\App\Http\Controllers\AnnouncementController::class, 'adminIndex'])->name('announcements.index');
    Route::get('/announcements/create', [\App\Http\Controllers\AnnouncementController::class, 'adminCreate'])->name('announcements.create');
    Route::post('/announcements', [\App\Http\Controllers\AnnouncementController::class, 'adminStore'])->name('announcements.store');

    // Homework
    Route::get('/homework', [\App\Http\Controllers\HomeworkController::class, 'adminIndex'])->name('homework.index');
    Route::get('/homework/create', [\App\Http\Controllers\HomeworkController::class, 'adminCreate'])->name('homework.create');
    Route::post('/homework', [\App\Http\Controllers\HomeworkController::class, 'adminStore'])->name('homework.store');

    // Quizzes
    Route::get('/quizzes', [\App\Http\Controllers\QuizController::class, 'adminIndex'])->name('quizzes.index');
    Route::get('/quizzes/create', [\App\Http\Controllers\QuizController::class, 'adminCreate'])->name('quizzes.create');
    Route::post('/quizzes', [\App\Http\Controllers\QuizController::class, 'adminStore'])->name('quizzes.store');

    // Tests
    Route::get('/tests', fn() => view('admin.tests.index'))->name('tests.index');

    // Resources
    Route::get('/resources', [\App\Http\Controllers\ResourceController::class, 'adminIndex'])->name('resources.index');
    Route::get('/resources/create', [\App\Http\Controllers\ResourceController::class, 'adminCreate'])->name('resources.create');
    Route::post('/resources', [\App\Http\Controllers\ResourceController::class, 'adminStore'])->name('resources.store');

    Route::get('/settings', fn() => view('admin.settings.index'))->name('settings.index');
    Route::get('/logs', fn() => view('admin.logs.index'))->name('logs.index');
});

// Teacher Routes
Route::prefix('teacher')->middleware(['auth', 'role:teacher'])->name('teacher.')->group(function () {
    Route::get('/', [TeacherDashboardController::class, 'index'])->name('dashboard');
    Route::get('/classrooms', [\App\Http\Controllers\MeetingController::class, 'index'])->name('classrooms.index');
    Route::get('/students', fn() => view('teacher.students.index'))->name('students.index');

    // Class Groups
    Route::get('/class-groups', [\App\Http\Controllers\Teacher\ClassGroupController::class, 'index'])->name('class-groups.index');
    Route::get('/class-groups/create', [\App\Http\Controllers\Teacher\ClassGroupController::class, 'create'])->name('class-groups.create');
    Route::post('/class-groups', [\App\Http\Controllers\Teacher\ClassGroupController::class, 'store'])->name('class-groups.store');
    Route::get('/class-groups/{classGroup}/edit', [\App\Http\Controllers\Teacher\ClassGroupController::class, 'edit'])->name('class-groups.edit');
    Route::put('/class-groups/{classGroup}', [\App\Http\Controllers\Teacher\ClassGroupController::class, 'update'])->name('class-groups.update');
    Route::delete('/class-groups/{classGroup}', [\App\Http\Controllers\Teacher\ClassGroupController::class, 'destroy'])->name('class-groups.destroy');
    Route::post('/class-groups/{classGroup}/students', [\App\Http\Controllers\Teacher\ClassGroupController::class, 'addStudent'])->name('class-groups.add-student');
    Route::delete('/class-groups/{classGroup}/students/{student}', [\App\Http\Controllers\Teacher\ClassGroupController::class, 'removeStudent'])->name('class-groups.remove-student');
    Route::delete('/students/{student}', [App\Http\Controllers\Teacher\StudentController::class, 'destroy'])->name('students.destroy');
    Route::get('/applications', [App\Http\Controllers\Teacher\ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}/edit', [App\Http\Controllers\Teacher\ApplicationController::class, 'edit'])->name('applications.edit');
    Route::put('/applications/{application}', [App\Http\Controllers\Teacher\ApplicationController::class, 'update'])->name('applications.update');

    // Homework
    Route::get('/homework', [\App\Http\Controllers\HomeworkController::class, 'teacherIndex'])->name('homework.index');
    Route::get('/homework/create', [\App\Http\Controllers\HomeworkController::class, 'teacherCreate'])->name('homework.create');
    Route::post('/homework', [\App\Http\Controllers\HomeworkController::class, 'teacherStore'])->name('homework.store');

    // Quizzes
    Route::get('/quizzes', [\App\Http\Controllers\QuizController::class, 'teacherIndex'])->name('quizzes.index');
    Route::get('/quizzes/create', [\App\Http\Controllers\QuizController::class, 'teacherCreate'])->name('quizzes.create');
    Route::post('/quizzes', [\App\Http\Controllers\QuizController::class, 'teacherStore'])->name('quizzes.store');

    // Tests
    Route::get('/tests', fn() => view('teacher.tests.index'))->name('tests.index');

    // Announcements
    Route::get('/announcements', [\App\Http\Controllers\AnnouncementController::class, 'teacherIndex'])->name('announcements.index');
    Route::get('/announcements/create', [\App\Http\Controllers\AnnouncementController::class, 'teacherCreate'])->name('announcements.create');
    Route::post('/announcements', [\App\Http\Controllers\AnnouncementController::class, 'teacherStore'])->name('announcements.store');

    // Resources
    Route::get('/resources', [\App\Http\Controllers\ResourceController::class, 'teacherIndex'])->name('resources.index');
    Route::get('/resources/create', [\App\Http\Controllers\ResourceController::class, 'teacherCreate'])->name('resources.create');
    Route::post('/resources', [\App\Http\Controllers\ResourceController::class, 'teacherStore'])->name('resources.store');
});

// Student Routes
Route::prefix('student')->middleware(['auth', 'role:student'])->name('student.')->group(function () {
    Route::get('/', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/meetings', [\App\Http\Controllers\Student\MeetingController::class, 'index'])->name('meetings.index');
    Route::get('/homework', [\App\Http\Controllers\HomeworkController::class, 'studentIndex'])->name('homework.index');
    Route::get('/quizzes', [\App\Http\Controllers\QuizController::class, 'studentIndex'])->name('quizzes.index');
    Route::get('/tests', fn() => view('student.tests.index'))->name('tests.index');
    Route::get('/resources', [\App\Http\Controllers\ResourceController::class, 'studentIndex'])->name('resources.index');
    Route::get('/grades', fn() => view('student.grades.index'))->name('grades.index');
    Route::get('/attendance', fn() => view('student.attendance.index'))->name('attendance.index');
});

// Shared Authenticated Routes for Meetings & Profile
Route::middleware('auth')->group(function () {
    Route::get('/meetings/create', [\App\Http\Controllers\MeetingController::class, 'create'])->name('meetings.create');
    Route::post('/meetings', [\App\Http\Controllers\MeetingController::class, 'store'])->name('meetings.store');
    Route::get('/meetings/{meeting}/edit', [\App\Http\Controllers\MeetingController::class, 'edit'])->name('meetings.edit');
    Route::put('/meetings/{meeting}', [\App\Http\Controllers\MeetingController::class, 'update'])->name('meetings.update');
    Route::get('/meetings/{meeting}/join', [\App\Http\Controllers\MeetingController::class, 'join'])->name('meetings.join');

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


