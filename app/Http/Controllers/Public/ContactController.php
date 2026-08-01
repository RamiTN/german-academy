<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('public.contact', [
            'seoTitle' => 'Contact Us — German Academy',
            'seoDescription' => 'Get in touch with German Academy. Ask about German language courses, schedules, pricing, or get help determining your current level.',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($validated);

        return redirect()->route('contact')->with('success', 'Your message has been sent successfully!');
    }
}
