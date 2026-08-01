<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    /**
     * Display all meetings for the student's class group.
     */
    public function index(Request $request)
    {
        $student = $request->user()->student;
        $classGroupId = $student->class_group_id;

        if (!$classGroupId) {
            return view('student.meetings.index', [
                'liveMeetings' => collect(),
                'upcomingMeetings' => collect(),
                'pastMeetings' => collect(),
                'classGroup' => null,
            ]);
        }

        $classGroup = $student->classGroup;

        // Live meetings (highest priority)
        $liveMeetings = Meeting::where('class_group_id', $classGroupId)
            ->where('status', 'live')
            ->with('teacher.user')
            ->orderBy('started_at', 'desc')
            ->get();

        // Upcoming scheduled meetings
        $upcomingMeetings = Meeting::where('class_group_id', $classGroupId)
            ->where('status', 'scheduled')
            ->where('scheduled_at', '>=', now())
            ->with('teacher.user')
            ->orderBy('scheduled_at', 'asc')
            ->get();

        // Past / ended meetings (last 10)
        $pastMeetings = Meeting::where('class_group_id', $classGroupId)
            ->whereIn('status', ['ended', 'cancelled'])
            ->with('teacher.user')
            ->orderBy('scheduled_at', 'desc')
            ->limit(10)
            ->get();

        return view('student.meetings.index', compact(
            'liveMeetings',
            'upcomingMeetings',
            'pastMeetings',
            'classGroup'
        ));
    }
}
