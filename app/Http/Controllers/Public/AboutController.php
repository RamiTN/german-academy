<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function index()
    {
        return view('public.about', [
            'seoTitle' => 'About the Teacher — German Academy',
            'seoDescription' => 'Meet the qualified German language instructor behind German Academy. Learn about teaching philosophy, qualifications, and years of experience helping students succeed.',
        ]);
    }
}
