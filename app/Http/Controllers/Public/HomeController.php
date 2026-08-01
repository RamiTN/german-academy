<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Smart redirect if already logged in
        if (auth()->check()) {
            if (auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif (auth()->user()->isTeacher()) {
                return redirect()->route('teacher.dashboard');
            } else {
                return redirect()->route('student.dashboard');
            }
        }

        return view('public.home', [
            'seoTitle' => 'German Academy — Learn German Online A1 to C2',
            'seoDescription' => 'Master the German language with live interactive online lessons, structured CEFR curriculum, and certified teachers. Enroll in A1–C2 courses at German Academy.',
        ]);
    }
}
