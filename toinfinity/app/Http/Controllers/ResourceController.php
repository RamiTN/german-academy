<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ClassGroup;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function teacherIndex(Request $request)
    {
        $teacher = $request->user()->teacher;
        $resources = Resource::with('classGroup')
            ->where('teacher_id', $teacher->id ?? 0)
            ->latest()
            ->get();

        return view('teacher.resources.index', compact('resources'));
    }

    public function teacherCreate(Request $request)
    {
        $teacher = $request->user()->teacher;
        $classGroups = $teacher ? $teacher->classGroups : ClassGroup::all();
        return view('teacher.resources.create', compact('classGroups'));
    }

    public function teacherStore(Request $request)
    {
        $validated = $request->validate([
            'class_group_id' => 'nullable|exists:class_groups,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:pdf,ppt,image,video,link,other',
            'external_url' => 'nullable|url',
        ]);

        $teacher = $request->user()->teacher;

        Resource::create([
            'class_group_id' => $validated['class_group_id'] ?? null,
            'teacher_id' => $teacher->id ?? 1,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? '',
            'type' => $validated['type'],
            'external_url' => $validated['external_url'] ?? '#',
        ]);

        return redirect()->route('teacher.resources.index')->with('success', __('Resource uploaded successfully!'));
    }

    public function adminIndex()
    {
        $resources = Resource::with(['classGroup', 'teacher.user'])->latest()->get();
        return view('admin.resources.index', compact('resources'));
    }

    public function adminCreate()
    {
        $classGroups = ClassGroup::all();
        return view('admin.resources.create', compact('classGroups'));
    }

    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'class_group_id' => 'nullable|exists:class_groups,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:pdf,ppt,image,video,link,other',
            'external_url' => 'nullable|url',
        ]);

        Resource::create([
            'class_group_id' => $validated['class_group_id'] ?? null,
            'teacher_id' => 1,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? '',
            'type' => $validated['type'],
            'external_url' => $validated['external_url'] ?? '#',
        ]);

        return redirect()->route('admin.resources.index')->with('success', __('Resource uploaded successfully!'));
    }

    public function studentIndex(Request $request)
    {
        $student = $request->user()->student;
        $classGroupId = $student->class_group_id ?? 0;
        $resources = Resource::where(function ($q) use ($classGroupId) {
            $q->whereNull('class_group_id')->orWhere('class_group_id', $classGroupId);
        })->latest()->get();

        return view('student.resources.index', compact('resources'));
    }
}
