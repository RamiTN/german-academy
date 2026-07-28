<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::latest()->paginate(10);
        return view('teacher.applications.index', compact('applications'));
    }

    public function edit(Application $application)
    {
        return view('teacher.applications.edit', compact('application'));
    }

    public function update(Request $request, Application $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'notes' => 'nullable|string',
        ]);

        $application->update($validated);

        return redirect()->route('teacher.applications.index')->with('success', 'Application updated successfully.');
    }
}
