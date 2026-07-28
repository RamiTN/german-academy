<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\HomeworkSubmission;
use App\Models\Meeting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $teacher = $request->user()->teacher;

        $stats = [
            'total_students' => $teacher->classGroups()->withCount('students')->get()->sum('students_count'),
            'today_lessons' => $teacher->meetings()->whereDate('scheduled_at', today())->count(),
            'pending_homework' => HomeworkSubmission::whereHas('homework', function ($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })->whereNull('graded_at')->count(),
        ];

        $todayLessons = $teacher->meetings()
            ->with('classGroup')
            ->whereDate('scheduled_at', today())
            ->orderBy('scheduled_at')
            ->get();

        $recentSubmissions = HomeworkSubmission::with(['homework', 'student.user'])
            ->whereHas('homework', function ($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })
            ->whereNull('graded_at')
            ->latest('submitted_at')
            ->take(5)
            ->get();

        return view('teacher.dashboard', compact('stats', 'todayLessons', 'recentSubmissions'));
    }
}
