<x-public-layout
    :seo-title="$seoTitle ?? null"
    :seo-description="$seoDescription ?? null"
    :seo-canonical="$seoCanonical ?? null"
    :seo-image="$seoImage ?? null"
    :seo-robots="$seoRobots ?? null"
>
    @push('head')
    <script type="application/ld+json">{!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'EducationalOrganization',
        'name' => 'German Academy',
        'url' => route('home'),
        'logo' => asset('images/5cbf0526-b5b8-447b-b43f-0b04d9925d8b.png'),
        'description' => 'Educational platform for learning German online from A1 to C2 with live interactive lessons and certified instructors.',
        'sameAs' => [],
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
    @endpush
    <!-- Hero Section -->
    <section class="bg-dark text-white pt-24 pb-32 overflow-hidden relative">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-accent via-dark to-dark"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-5xl md:text-6xl font-bold tracking-tight mb-6 mt-8">
                {{ __('Learn German Online') }}
            </h1>
            <p class="text-xl md:text-2xl text-gray-400 max-w-3xl mx-auto mb-10">
                {{ __('Master the German language with live interactive lessons, structured curriculum, and a premium learning experience tailored for real results.') }}
            </p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('apply') }}" class="btn-primary text-lg px-8 py-3">{{ __('Apply Now') }} &rarr;</a>
                <a href="{{ route('how-it-works') }}" class="bg-white/10 hover:bg-white/20 text-white btn text-lg px-8 py-3">{{ __('How it works') }}</a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __('Why choose the Academy?') }}</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">{{ __('We focus on real conversational skills and academic excellence, not just vocabulary memorization.') }}</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <x-ui.card class="text-center p-8 border-none bg-[#FAFAFA]">
                    <div class="w-16 h-16 bg-accent-subtle rounded-2xl flex items-center justify-center mx-auto mb-6 text-accent">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">{{ __('Live Video Lessons') }}</h3>
                    <p class="text-gray-500">{{ __('Interactive sessions via Google Meet. Practice speaking in real-time with immediate feedback.') }}</p>
                </x-ui.card>

                <x-ui.card class="text-center p-8 border-none bg-[#FAFAFA]">
                    <div class="w-16 h-16 bg-accent-subtle rounded-2xl flex items-center justify-center mx-auto mb-6 text-accent">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">{{ __('Structured Curriculum') }}</h3>
                    <p class="text-gray-500">{{ __('A clear path from A1 to B1. Follow a proven syllabus with homework, quizzes, and regular tests.') }}</p>
                </x-ui.card>

                <x-ui.card class="text-center p-8 border-none bg-[#FAFAFA]">
                    <div class="w-16 h-16 bg-accent-subtle rounded-2xl flex items-center justify-center mx-auto mb-6 text-accent">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">{{ __('Certified Results') }}</h3>
                    <p class="text-gray-500">{{ __('Prepare thoroughly for official Goethe-Institut and TestDaF examinations with targeted practice.') }}</p>
                </x-ui.card>
            </div>
        </div>
    </section>

    <!-- Levels -->
    <section class="py-20 bg-[#FAFAFA]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __('Levels Taught') }}</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">{{ __('Based on the Common European Framework of Reference for Languages (CEFR).') }}</p>
            </div>

            <div class="max-w-3xl mx-auto grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach(['A1' => 'Beginner', 'A2' => 'Elementary', 'B1' => 'Intermediate'] as $level => $label)
                    <div class="bg-white rounded-2xl border border-gray-200 p-6 text-center hover:border-accent transition-colors hover:shadow-md">
                        <div class="text-3xl font-bold text-dark mb-2">{{ $level }}</div>
                        <div class="text-sm text-gray-500 font-medium">{{ __($label) }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 bg-white relative overflow-hidden">
        <div class="absolute -right-40 -top-40 w-96 h-96 bg-accent-subtle rounded-full blur-3xl opacity-50"></div>
        <div class="absolute -left-40 -bottom-40 w-96 h-96 bg-accent-subtle rounded-full blur-3xl opacity-50"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-4xl font-bold text-gray-900 mb-6">{{ __('Ready to start your journey?') }}</h2>
            <p class="text-xl text-gray-500 mb-10">{{ __('Applications are currently open for the upcoming semester. Spaces are strictly limited to ensure quality teaching.') }}</p>
            <a href="{{ route('apply') }}" class="btn-primary text-lg px-10 py-4 shadow-lg shadow-accent/20">{{ __('Submit Application') }}</a>
        </div>
    </section>
</x-public-layout>