<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use App\Models\ClassGroup;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    public function teacherIndex(Request $request)
    {
        $teacher = $request->user()->teacher;
        $homeworks = Homework::with('classGroup')
            ->where('teacher_id', $teacher->id ?? 0)
            ->latest()
            ->get();

        return view('teacher.homework.index', compact('homeworks'));
    }

    public function teacherCreate(Request $request)
    {
        $teacher = $request->user()->teacher;
        $classGroups = $teacher ? $teacher->classGroups : ClassGroup::all();
        return view('teacher.homework.create', compact('classGroups'));
    }

    public function teacherStore(Request $request)
    {
        $validated = $request->validate([
            'class_group_id' => 'required|exists:class_groups,id',
            'title' => 'required|string|max:255',
            'instructions' => 'required|string',
            'deadline' => 'required|date',
            'max_score' => 'nullable|integer|min:1',
        ]);

        $teacher = $request->user()->teacher;

        Homework::create([
            'class_group_id' => $validated['class_group_id'],
            'teacher_id' => $teacher->id ?? 1,
            'title' => $validated['title'],
            'instructions' => $validated['instructions'],
            'deadline' => $validated['deadline'],
            'max_score' => $validated['max_score'] ?? 100,
            'is_published' => true,
        ]);

        return redirect()->route('teacher.homework.index')->with('success', __('Homework created successfully!'));
    }

    public function adminIndex()
    {
        $homeworks = Homework::with(['classGroup', 'teacher.user'])->latest()->get();
        return view('admin.homework.index', compact('homeworks'));
    }

    public function adminCreate()
    {
        $classGroups = ClassGroup::all();
        return view('admin.homework.create', compact('classGroups'));
    }

    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'class_group_id' => 'required|exists:class_groups,id',
            'title' => 'required|string|max:255',
            'instructions' => 'required|string',
            'deadline' => 'required|date',
            'max_score' => 'nullable|integer|min:1',
        ]);

        Homework::create([
            'class_group_id' => $validated['class_group_id'],
            'teacher_id' => 1,
            'title' => $validated['title'],
            'instructions' => $validated['instructions'],
            'deadline' => $validated['deadline'],
            'max_score' => $validated['max_score'] ?? 100,
            'is_published' => true,
        ]);

        return redirect()->route('admin.homework.index')->with('success', __('Homework created successfully!'));
    }

    public function studentIndex(Request $request)
    {
        $student = $request->user()->student;
        $classGroupId = $student->class_group_id ?? 0;
        $homeworks = Homework::where('class_group_id', $classGroupId)
            ->where('is_published', true)
            ->latest()
            ->get();

        return view('student.homework.index', compact('homeworks'));
    }
}
