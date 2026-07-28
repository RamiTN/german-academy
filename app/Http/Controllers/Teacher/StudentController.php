<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function destroy(Student $student)
    {
        // For now, let's say removing a student from a class means setting their class_group_id to null
        $student->update(['class_group_id' => null]);

        return redirect()->route('teacher.students.index')->with('success', 'Student removed from class.');
    }
}
