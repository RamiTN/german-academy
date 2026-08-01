<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\GermanLevel;
use App\Http\Controllers\Controller;
use App\Models\ClassGroup;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClassGroupController extends Controller
{
    /**
     * Display a listing of the teacher's class groups.
     */
    public function index(Request $request)
    {
        $teacher = $request->user()->teacher;

        $classGroups = ClassGroup::where('teacher_id', $teacher->id)
            ->withCount('students')
            ->with(['meetings' => function ($q) {
                $q->where('status', '!=', 'ended')
                  ->where('status', '!=', 'cancelled')
                  ->orderBy('scheduled_at', 'asc')
                  ->limit(3);
            }])
            ->latest()
            ->get();

        return view('teacher.class-groups.index', compact('classGroups'));
    }

    /**
     * Show the form for creating a new class group.
     */
    public function create()
    {
        $levels = GermanLevel::cases();

        return view('teacher.class-groups.create', compact('levels'));
    }

    /**
     * Store a newly created class group.
     */
    public function store(Request $request)
    {
        $teacher = $request->user()->teacher;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'german_level' => 'required|string',
            'description' => 'nullable|string|max:1000',
            'max_students' => 'required|integer|min:1|max:100',
            'is_active' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            ClassGroup::create([
                'name' => $validated['name'],
                'german_level' => $validated['german_level'],
                'teacher_id' => $teacher->id,
                'description' => $validated['description'] ?? null,
                'max_students' => $validated['max_students'],
                'is_active' => $request->boolean('is_active', true),
            ]);

            DB::commit();

            return redirect()->route('teacher.class-groups.index')
                ->with('success', 'Class group created successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to create class group: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Could not create the class group. Please try again.');
        }
    }

    /**
     * Show the form for editing a class group (includes student management).
     */
    public function edit(Request $request, ClassGroup $classGroup)
    {
        $teacher = $request->user()->teacher;

        if ($classGroup->teacher_id !== $teacher->id) {
            abort(403, 'You are not authorized to edit this class group.');
        }

        $classGroup->load(['students.user', 'meetings' => function ($q) {
            $q->orderBy('scheduled_at', 'desc')->limit(5);
        }]);

        $levels = GermanLevel::cases();

        // Students not assigned to any class group (available for assignment)
        $availableStudents = Student::whereNull('class_group_id')
            ->with('user')
            ->get();

        return view('teacher.class-groups.edit', compact('classGroup', 'levels', 'availableStudents'));
    }

    /**
     * Update the class group.
     */
    public function update(Request $request, ClassGroup $classGroup)
    {
        $teacher = $request->user()->teacher;

        if ($classGroup->teacher_id !== $teacher->id) {
            abort(403, 'You are not authorized to update this class group.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'german_level' => 'required|string',
            'description' => 'nullable|string|max:1000',
            'max_students' => 'required|integer|min:1|max:100',
            'is_active' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $classGroup->update([
                'name' => $validated['name'],
                'german_level' => $validated['german_level'],
                'description' => $validated['description'] ?? null,
                'max_students' => $validated['max_students'],
                'is_active' => $request->boolean('is_active', true),
            ]);

            DB::commit();

            return redirect()->route('teacher.class-groups.edit', $classGroup)
                ->with('success', 'Class group updated successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to update class group: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Could not update the class group. Please try again.');
        }
    }

    /**
     * Delete the class group.
     */
    public function destroy(Request $request, ClassGroup $classGroup)
    {
        $teacher = $request->user()->teacher;

        if ($classGroup->teacher_id !== $teacher->id) {
            abort(403, 'You are not authorized to delete this class group.');
        }

        try {
            DB::beginTransaction();

            // Unassign all students first
            Student::where('class_group_id', $classGroup->id)
                ->update(['class_group_id' => null]);

            $classGroup->delete();

            DB::commit();

            return redirect()->route('teacher.class-groups.index')
                ->with('success', 'Class group deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to delete class group: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Could not delete the class group. Please try again.');
        }
    }

    /**
     * Add a student to the class group.
     */
    public function addStudent(Request $request, ClassGroup $classGroup)
    {
        $teacher = $request->user()->teacher;

        if ($classGroup->teacher_id !== $teacher->id) {
            abort(403);
        }

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $student = Student::findOrFail($validated['student_id']);

        // Check if student is already in a class group
        if ($student->class_group_id !== null) {
            return redirect()->back()
                ->with('error', 'This student is already assigned to a class group.');
        }

        // Check if group is full
        if ($classGroup->isFull()) {
            return redirect()->back()
                ->with('error', 'This class group is full (max ' . $classGroup->max_students . ' students).');
        }

        try {
            $student->update(['class_group_id' => $classGroup->id]);

            return redirect()->route('teacher.class-groups.edit', $classGroup)
                ->with('success', $student->user->name . ' has been added to the class group.');
        } catch (\Throwable $e) {
            Log::error('Failed to add student to class group: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Could not add the student. Please try again.');
        }
    }

    /**
     * Remove a student from the class group.
     */
    public function removeStudent(Request $request, ClassGroup $classGroup, Student $student)
    {
        $teacher = $request->user()->teacher;

        if ($classGroup->teacher_id !== $teacher->id) {
            abort(403);
        }

        if ($student->class_group_id !== $classGroup->id) {
            return redirect()->back()
                ->with('error', 'This student is not in this class group.');
        }

        try {
            $student->update(['class_group_id' => null]);

            return redirect()->route('teacher.class-groups.edit', $classGroup)
                ->with('success', $student->user->name . ' has been removed from the class group.');
        } catch (\Throwable $e) {
            Log::error('Failed to remove student from class group: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Could not remove the student. Please try again.');
        }
    }
}
