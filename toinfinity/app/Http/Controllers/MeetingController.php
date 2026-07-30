<?php

namespace App\Http\Controllers;

use App\Enums\AttendanceStatus;
use App\Enums\MeetingStatus;
use App\Models\Attendance;
use App\Models\ClassGroup;
use App\Models\Meeting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MeetingController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of class groups and meetings.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isTeacher() && $user->teacher) {
            $classGroups = ClassGroup::where('teacher_id', $user->teacher->id)
                ->with(['meetings' => function ($q) {
                    $q->orderBy('scheduled_at', 'asc');
                }, 'students'])
                ->get();
        } else {
            $classGroups = ClassGroup::with(['teacher.user', 'meetings' => function ($q) {
                $q->orderBy('scheduled_at', 'asc');
            }, 'students'])
                ->get();
        }

        return view('teacher.classrooms.index', compact('classGroups'));
    }

    /**
     * Show form to create a new meeting.
     */
    public function create(Request $request)
    {
        $user = $request->user();

        if ($user->isTeacher() && $user->teacher) {
            $classGroups = ClassGroup::where('teacher_id', $user->teacher->id)
                ->where('is_active', true)
                ->get();
        } else {
            $classGroups = ClassGroup::where('is_active', true)->with('teacher.user')->get();
        }

        return view('meetings.create', compact('classGroups'));
    }

    /**
     * Store a newly created meeting in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'class_group_id' => 'required|exists:class_groups,id',
            'scheduled_at' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $classGroup = ClassGroup::findOrFail($validated['class_group_id']);

        if ($user->isTeacher() && $user->teacher && $classGroup->teacher_id !== $user->teacher->id) {
            return redirect()->back()->with('error', 'You are not assigned as the teacher for this class group.');
        }

        try {
            DB::beginTransaction();

            $meeting = Meeting::create([
                'title' => $validated['title'],
                'class_group_id' => $classGroup->id,
                'teacher_id' => $classGroup->teacher_id ?? ($user->teacher->id ?? null),
                'scheduled_at' => $validated['scheduled_at'],
                'status' => MeetingStatus::Scheduled,
                'notes' => $validated['notes'] ?? null,
                'meet_link' => null,
            ]);

            DB::commit();

            return redirect()->route('teacher.classrooms.index')
                ->with('success', 'Meeting scheduled successfully! You can attach a Google Meet link when ready.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to create meeting: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Database connection error: Could not schedule meeting. Please try again.');
        }
    }

    /**
     * Show form to edit meeting (paste meet_link or change status).
     */
    public function edit(Request $request, Meeting $meeting)
    {
        $this->authorize('update', $meeting);

        return view('meetings.edit', compact('meeting'));
    }

    /**
     * Update meeting details or Google Meet link.
     */
    public function update(Request $request, Meeting $meeting)
    {
        $this->authorize('update', $meeting);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'meet_link' => 'nullable|url|starts_with:https://meet.google.com/',
            'status' => 'required|string|in:scheduled,live,ended,cancelled',
            'scheduled_at' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $data = [
                'title' => $validated['title'],
                'meet_link' => $validated['meet_link'] ?: null,
                'status' => $validated['status'],
                'scheduled_at' => $validated['scheduled_at'],
                'notes' => $validated['notes'] ?: null,
            ];

            if ($validated['status'] === 'live' && !$meeting->started_at) {
                $data['started_at'] = now();
            }

            if ($validated['status'] === 'ended' && !$meeting->ended_at) {
                $data['ended_at'] = now();
            }

            $meeting->update($data);

            DB::commit();

            return redirect()->route('teacher.classrooms.index')
                ->with('success', 'Meeting details and Google Meet link updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to update meeting: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Database connection error: Could not update meeting details. Please try again.');
        }
    }

    /**
     * Join the meeting, record attendance automatically, and redirect to Google Meet.
     */
    public function join(Request $request, Meeting $meeting)
    {
        $user = $request->user();

        if (!$meeting->meet_link) {
            return redirect()->back()->with('error', 'No Google Meet link has been added for this lesson yet.');
        }

        // Authorize join access
        $this->authorize('join', $meeting);

        // Record attendance if student
        if ($user->isStudent() && $user->student) {
            try {
                if ($user->student->class_group_id === $meeting->class_group_id) {
                    Attendance::updateOrCreate(
                        [
                            'meeting_id' => $meeting->id,
                            'student_id' => $user->student->id,
                        ],
                        [
                            'status' => AttendanceStatus::Present,
                            'marked_by' => $user->id,
                            'notes' => 'Auto-recorded upon joining Google Meet',
                        ]
                    );
                }
            } catch (\Throwable $e) {
                Log::error('Failed to record attendance on join: ' . $e->getMessage());
                // Non-blocking for student joining the call
            }
        }

        return redirect()->away($meeting->meet_link);
    }
}
