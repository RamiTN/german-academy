<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Teachers ──
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->text('bio')->nullable();
            $table->text('experience')->nullable();
            $table->json('certificates')->nullable();
            $table->text('philosophy')->nullable();
            $table->string('profile_image')->nullable();
            $table->json('specializations')->nullable();
            $table->timestamps();
        });

        // ── Class Groups ──
        Schema::create('class_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('german_level');
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->unsignedInteger('max_students')->default(20);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('german_level');
        });

        // ── Students ──
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('class_group_id')->nullable()->constrained('class_groups')->nullOnDelete();
            $table->string('german_level')->nullable();
            $table->date('enrollment_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('german_level');
        });

        // ── Applications ──
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 50)->nullable();
            $table->string('german_level')->default('none');
            $table->string('preferred_schedule')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('pending');
            $table->text('admin_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->index('status');
        });

        // ── Schedules ──
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_group_id')->constrained('class_groups')->cascadeOnDelete();
            $table->unsignedTinyInteger('day_of_week'); // 0=Sunday...6=Saturday
            $table->time('start_time');
            $table->time('end_time');
            $table->string('timezone', 50)->default('Europe/Berlin');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // ── Meetings (Live Lessons) ──
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_group_id')->constrained('class_groups')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->string('title');
            $table->string('meet_link', 500)->nullable();
            $table->string('google_event_id')->nullable();
            $table->string('status')->default('scheduled');
            $table->dateTime('scheduled_at');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('scheduled_at');
        });

        // ── Attendance ──
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained('meetings')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->string('status');
            $table->string('notes')->nullable();
            $table->foreignId('marked_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['meeting_id', 'student_id']);
        });

        // ── Homework ──
        Schema::create('homework', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_group_id')->constrained('class_groups')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->string('title');
            $table->text('instructions');
            $table->string('file_path', 500)->nullable();
            $table->string('file_name')->nullable();
            $table->dateTime('deadline');
            $table->unsignedInteger('max_score')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index('deadline');
        });

        // ── Homework Submissions ──
        Schema::create('homework_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('homework_id')->constrained('homework')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->string('file_path', 500)->nullable();
            $table->string('file_name')->nullable();
            $table->text('text_content')->nullable();
            $table->unsignedInteger('score')->nullable();
            $table->text('feedback')->nullable();
            $table->foreignId('graded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('graded_at')->nullable();
            $table->dateTime('submitted_at');
            $table->timestamps();

            $table->unique(['homework_id', 'student_id']);
        });

        // ── Quizzes ──
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_group_id')->constrained('class_groups')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('time_limit_minutes')->nullable();
            $table->boolean('is_published')->default(false);
            $table->dateTime('available_from')->nullable();
            $table->dateTime('available_until')->nullable();
            $table->timestamps();
        });

        // ── Quiz Questions ──
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->string('type');
            $table->text('question_text');
            $table->json('options')->nullable();
            $table->text('correct_answer');
            $table->unsignedInteger('points')->default(1);
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });

        // ── Quiz Attempts ──
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->json('answers')->nullable();
            $table->unsignedInteger('score')->nullable();
            $table->unsignedInteger('total_points')->nullable();
            $table->dateTime('started_at');
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['quiz_id', 'student_id']);
        });

        // ── Tests ──
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_group_id')->constrained('class_groups')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('time_limit_minutes');
            $table->dateTime('available_from');
            $table->dateTime('available_until');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });

        // ── Test Questions ──
        Schema::create('test_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained('tests')->cascadeOnDelete();
            $table->string('type');
            $table->text('question_text');
            $table->json('options')->nullable();
            $table->text('correct_answer')->nullable();
            $table->unsignedInteger('points')->default(1);
            $table->unsignedInteger('order')->default(0);
            $table->boolean('requires_manual_grading')->default(false);
            $table->timestamps();
        });

        // ── Test Attempts ──
        Schema::create('test_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained('tests')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->json('answers')->nullable();
            $table->unsignedInteger('auto_score')->nullable();
            $table->unsignedInteger('manual_score')->nullable();
            $table->unsignedInteger('total_score')->nullable();
            $table->unsignedInteger('total_points')->nullable();
            $table->foreignId('graded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('graded_at')->nullable();
            $table->dateTime('started_at');
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['test_id', 'student_id']);
        });

        // ── Grades (Aggregate / Polymorphic) ──
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->string('gradeable_type');
            $table->unsignedBigInteger('gradeable_id');
            $table->decimal('score', 5, 2);
            $table->decimal('max_score', 5, 2);
            $table->decimal('percentage', 5, 2);
            $table->text('feedback')->nullable();
            $table->foreignId('graded_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->index(['gradeable_type', 'gradeable_id']);
        });

        // ── Announcements ──
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_group_id')->nullable()->constrained('class_groups')->cascadeOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('content');
            $table->boolean('is_pinned')->default(false);
            $table->dateTime('published_at');
            $table->timestamps();
        });

        // ── Resources ──
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_group_id')->nullable()->constrained('class_groups')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type'); // pdf, ppt, image, video, link
            $table->string('file_path', 500)->nullable();
            $table->string('file_name')->nullable();
            $table->string('external_url', 500)->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->unsignedInteger('download_count')->default(0);
            $table->timestamps();
        });

        // ── Settings ──
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group', 50)->default('general');
            $table->string('key', 100);
            $table->text('value')->nullable();
            $table->timestamps();

            $table->unique(['group', 'key']);
        });

        // ── Activity Logs ──
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action');
            $table->text('description')->nullable();
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->index(['subject_type', 'subject_id']);
            $table->index('action');
        });

        // ── Contact Messages ──
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('subject')->nullable();
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        // ── Notifications ──
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        $tables = [
            'notifications', 'contact_messages', 'activity_logs', 'settings', 'resources',
            'announcements', 'grades', 'test_attempts', 'test_questions', 'tests',
            'quiz_attempts', 'quiz_questions', 'quizzes',
            'homework_submissions', 'homework', 'attendances', 'meetings',
            'schedules', 'applications', 'students', 'class_groups', 'teachers',
        ];

        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
    }
};
