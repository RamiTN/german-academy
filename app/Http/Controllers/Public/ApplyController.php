<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplyController extends Controller
{
    public function index()
    {
        return view('public.apply');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'german_level' => 'required|string|in:A1,A2,B1,B2,C1,C2,none',
            'preferred_schedule' => 'nullable|string|max:255',
            'message' => 'nullable|string',
        ]);

        Application::create($validated);

        return redirect()->route('apply')->with('success', 'Your application has been submitted successfully! We will contact you soon.');
    }
}
