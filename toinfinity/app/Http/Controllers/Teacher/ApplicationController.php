<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\ApplicationStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ClassGroup;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->paginate(10)->withQueryString();

        return view('teacher.applications.index', compact('applications'));
    }

    public function edit(Application $application)
    {
        $classGroups = ClassGroup::where('is_active', true)->get();

        return view('teacher.applications.edit', compact('application', 'classGroups'));
    }

    public function update(Request $request, Application $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'class_group_id' => 'nullable|exists:class_groups,id',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $statusEnum = ApplicationStatus::from($validated['status']);

            if ($statusEnum === ApplicationStatus::Approved) {
                // Find or create User
                $user = User::where('email', $application->email)->first();

                if (!$user) {
                    $user = User::create([
                        'name' => $application->name,
                        'email' => $application->email,
                        'phone' => $application->phone,
                        'password' => Hash::make(Str::random(12)),
                        'role' => UserRole::Student,
                        'status' => 'active',
                    ]);
                }

                // Create or update Student record
                Student::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'class_group_id' => $validated['class_group_id'] ?? null,
                        'german_level' => $application->german_level,
                        'enrollment_date' => now(),
                        'notes' => $validated['notes'] ?? null,
                    ]
                );
            }

            $application->update([
                'status' => $statusEnum,
                'admin_notes' => $validated['notes'] ?? null,
                'reviewed_by' => $request->user()->id,
                'reviewed_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('teacher.applications.index')
                ->with('success', 'Application status updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to update application status: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Database connection error: Failed to process application. Please try again.');
        }
    }
}
