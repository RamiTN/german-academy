<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Homework;
use App\Models\Meeting;
use App\Models\Quiz;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $student = $request->user()->student;
        $classGroupId = $student->class_group_id;

        // Feed Items Collection
        $feed = collect();

        // 1. Live Meeting
        $liveMeeting = Meeting::where('class_group_id', $classGroupId)
            ->where('status', 'live')
            ->first();
        
        if ($liveMeeting) {
            $feed->push([
                'type' => 'live',
                'priority' => 100,
                'data' => $liveMeeting
            ]);
        }

        // 2. Next Lesson Today
        $nextLesson = Meeting::where('class_group_id', $classGroupId)
            ->whereDate('scheduled_at', today())
            ->where('status', 'scheduled')
            ->orderBy('scheduled_at')
            ->first();

        if ($nextLesson && !$liveMeeting) {
            $feed->push([
                'type' => 'next_lesson',
                'priority' => 90,
                'data' => $nextLesson
            ]);
        }

        // 3. Pending Homework
        $pendingHomeworks = Homework::where('class_group_id', $classGroupId)
            ->where('is_published', true)
            ->whereDoesntHave('submissions', function ($q) use ($student) {
                $q->where('student_id', $student->id);
            })
            ->where('deadline', '>', now())
            ->orderBy('deadline')
            ->take(3)
            ->get();

        foreach ($pendingHomeworks as $hw) {
            $feed->push([
                'type' => 'homework',
                'priority' => 80,
                'data' => $hw
            ]);
        }

        // 4. Available Quizzes
        $availableQuizzes = Quiz::where('class_group_id', $classGroupId)
            ->where('is_published', true)
            ->whereDoesntHave('attempts', function ($q) use ($student) {
                $q->where('student_id', $student->id)->whereNotNull('completed_at');
            })
            ->where(function($q) {
                $q->whereNull('available_from')->orWhere('available_from', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('available_until')->orWhere('available_until', '>=', now());
            })
            ->get();

        foreach ($availableQuizzes as $quiz) {
            $feed->push([
                'type' => 'quiz',
                'priority' => 70,
                'data' => $quiz
            ]);
        }

        // 5. Recent Announcements
        $announcements = Announcement::forClass($classGroupId)
            ->latest('published_at')
            ->take(5)
            ->get();

        foreach ($announcements as $ann) {
            $feed->push([
                'type' => 'announcement',
                'priority' => $ann->is_pinned ? 85 : 50,
                'data' => $ann
            ]);
        }

        // Sort feed by priority (desc) and date
        $feed = $feed->sortByDesc('priority')->values();

        $stats = [
            'attendance' => $student->attendance_percentage,
            'quiz_avg' => $student->quizAttempts()->whereNotNull('score')->avg('score') ?? 0,
        ];

        return view('student.dashboard', compact('feed', 'stats', 'student'));
    }
}
