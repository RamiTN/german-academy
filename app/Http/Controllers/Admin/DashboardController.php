<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Meeting;
use App\Models\Student;
use App\Models\Teacher;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students' => Student::count(),
            'total_teachers' => Teacher::count(),
            'pending_applications' => Application::where('status', 'pending')->count(),
            'today_lessons' => Meeting::whereDate('scheduled_at', today())->count(),
        ];

        $recentApplications = Application::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentApplications'));
    }
}
