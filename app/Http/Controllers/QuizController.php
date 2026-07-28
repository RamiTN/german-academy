<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\ClassGroup;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function teacherIndex(Request $request)
    {
        $teacher = $request->user()->teacher;
        $quizzes = Quiz::with('classGroup')
            ->where('teacher_id', $teacher->id ?? 0)
            ->latest()
            ->get();

        return view('teacher.quizzes.index', compact('quizzes'));
    }

    public function teacherCreate(Request $request)
    {
        $teacher = $request->user()->teacher;
        $classGroups = $teacher ? $teacher->classGroups : ClassGroup::all();
        return view('teacher.quizzes.create', compact('classGroups'));
    }

    public function teacherStore(Request $request)
    {
        $validated = $request->validate([
            'class_group_id' => 'required|exists:class_groups,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit_minutes' => 'nullable|integer|min:1',
        ]);

        $teacher = $request->user()->teacher;

        Quiz::create([
            'class_group_id' => $validated['class_group_id'],
            'teacher_id' => $teacher->id ?? 1,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? '',
            'time_limit_minutes' => $validated['time_limit_minutes'] ?? 15,
            'is_published' => true,
        ]);

        return redirect()->route('teacher.quizzes.index')->with('success', __('Quiz created successfully!'));
    }

    public function adminIndex()
    {
        $quizzes = Quiz::with(['classGroup', 'teacher.user'])->latest()->get();
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function adminCreate()
    {
        $classGroups = ClassGroup::all();
        return view('admin.quizzes.create', compact('classGroups'));
    }

    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'class_group_id' => 'required|exists:class_groups,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit_minutes' => 'nullable|integer|min:1',
        ]);

        Quiz::create([
            'class_group_id' => $validated['class_group_id'],
            'teacher_id' => 1,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? '',
            'time_limit_minutes' => $validated['time_limit_minutes'] ?? 15,
            'is_published' => true,
        ]);

        return redirect()->route('admin.quizzes.index')->with('success', __('Quiz created successfully!'));
    }

    public function studentIndex(Request $request)
    {
        $student = $request->user()->student;
        $classGroupId = $student->class_group_id ?? 0;
        $quizzes = Quiz::where('class_group_id', $classGroupId)
            ->where('is_published', true)
            ->latest()
            ->get();

        return view('student.quizzes.index', compact('quizzes'));
    }
}
