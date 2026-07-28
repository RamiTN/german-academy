<x-public-layout>
    <!-- Hero Section -->
    <section class="bg-dark text-white pt-20 pb-24 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-accent via-dark to-dark"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-bold tracking-tight mb-6">
                How German Academy Works
            </h1>
            <p class="text-lg md:text-xl text-gray-400 max-w-3xl mx-auto">
                A simple, structured, and effective roadmap to help you master the German language from your first live class to certified fluency.
            </p>
        </div>
    </section>

    <!-- Steps Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-12 relative">
                <!-- Step 1 -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-accent text-white font-bold text-2xl rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-accent/20">
                        1
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Apply & Placement</h3>
                    <p class="text-gray-500">
                        Sign up and submit your application detailing your current German knowledge, learning goals, and schedule preferences.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-accent text-white font-bold text-2xl rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-accent/20">
                        2
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Assessment & Group Matching</h3>
                    <p class="text-gray-500">
                        Our teachers review your application and match you to a class group aligned with your skill level and schedule.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-accent text-white font-bold text-2xl rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-accent/20">
                        3
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Live Interactive Learning</h3>
                    <p class="text-gray-500">
                        Attend live online classes, work on structured assignments, submit homework, take quizzes, and earn certificates.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features / Methodology -->
    <section class="py-20 bg-[#FAFAFA]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Teaching Methodology</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Combining traditional academic discipline with modern online interactive teaching tools.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <x-ui.card class="p-8">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-accent-subtle text-accent rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Structured Curriculum</h3>
                            <p class="text-gray-500 text-sm">Every course is built according to the CEFR framework (A1 to C2). Clear syllabus, defined goals, and progressive learning milestones.</p>
                        </div>
                    </div>
                </x-ui.card>

                <x-ui.card class="p-8">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-accent-subtle text-accent rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Small Group Sizes</h3>
                            <p class="text-gray-500 text-sm">Classes are intentionally kept small to guarantee high interaction, personalized correction, and ample speaking time for every student.</p>
                        </div>
                    </div>
                </x-ui.card>

                <x-ui.card class="p-8">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-accent-subtle text-accent rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Continuous Evaluation</h3>
                            <p class="text-gray-500 text-sm">Regular homework assignments, vocabulary quizzes, and module tests to track your progress and highlight areas for improvement.</p>
                        </div>
                    </div>
                </x-ui.card>

                <x-ui.card class="p-8">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-accent-subtle text-accent rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Interactive Student Portal</h3>
                            <p class="text-gray-500 text-sm">Access lesson materials, homework submissions, schedule updates, and class recordings anytime through your dedicated dashboard.</p>
                        </div>
                    </div>
                </x-ui.card>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-white text-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Ready to get started?</h2>
            <p class="text-gray-500 mb-8">Sign in to your account and submit an application for the upcoming batch.</p>
            @auth
                <a href="{{ route('apply') }}" class="btn-primary py-3 px-8 text-lg">Apply Now</a>
            @else
                <a href="{{ route('register') }}" class="btn-primary py-3 px-8 text-lg">Create Account & Apply</a>
            @endauth
        </div>
    </section>
</x-public-layout>
