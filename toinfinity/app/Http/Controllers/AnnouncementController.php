<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\ClassGroup;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function teacherIndex(Request $request)
    {
        $teacher = $request->user()->teacher;
        $announcements = Announcement::with('classGroup')
            ->where('teacher_id', $teacher->id ?? 0)
            ->latest()
            ->get();

        return view('teacher.announcements.index', compact('announcements'));
    }

    public function teacherCreate(Request $request)
    {
        $teacher = $request->user()->teacher;
        $classGroups = $teacher ? $teacher->classGroups : ClassGroup::all();
        return view('teacher.announcements.create', compact('classGroups'));
    }

    public function teacherStore(Request $request)
    {
        $validated = $request->validate([
            'class_group_id' => 'nullable|exists:class_groups,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_pinned' => 'nullable|boolean',
        ]);

        $teacher = $request->user()->teacher;

        Announcement::create([
            'class_group_id' => $validated['class_group_id'] ?? null,
            'teacher_id' => $teacher->id ?? 1,
            'created_by' => $request->user()->id,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'is_pinned' => $request->has('is_pinned'),
            'published_at' => now(),
        ]);

        return redirect()->route('teacher.announcements.index')->with('success', __('Announcement published successfully!'));
    }

    public function adminIndex()
    {
        $announcements = Announcement::with(['classGroup', 'creator'])->latest()->get();
        return view('admin.announcements.index', compact('announcements'));
    }

    public function adminCreate()
    {
        $classGroups = ClassGroup::all();
        return view('admin.announcements.create', compact('classGroups'));
    }

    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'class_group_id' => 'nullable|exists:class_groups,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_pinned' => 'nullable|boolean',
        ]);

        Announcement::create([
            'class_group_id' => $validated['class_group_id'] ?? null,
            'created_by' => $request->user()->id,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'is_pinned' => $request->has('is_pinned'),
            'published_at' => now(),
        ]);

        return redirect()->route('admin.announcements.index')->with('success', __('Announcement published successfully!'));
    }
}
