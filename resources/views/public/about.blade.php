<x-public-layout>
    <div class="bg-white py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 tracking-tight sm:text-5xl mb-6">
                        {{ __('About the Teacher') }}</h1>
                    <div class="prose prose-lg text-gray-500">
                        <p>
                            {{ __('Welcome to the German Academy. My philosophy is simple: language learning should be immersive, structured, and enjoyable.') }}
                        </p>
                        <p>
                            {{ __('Along my career in teaching , I have helped hundreds of students with there exams.') }}
                        </p>
                        <p>
                            {{ __('I believe in small group classes where every student gets the opportunity to speak and receive personal feedback. Unlike massive open online courses, here you are part of a dedicated learning community.') }}
                        </p>
                    </div>

                    <div class="mt-10 grid grid-cols-2 gap-8 border-t border-gray-100 pt-10">
                        <div>
                            <h3 class="font-bold text-gray-900 mb-2">{{ __('Qualifications') }}</h3>
                            <ul class="text-sm text-gray-600 space-y-2">
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-accent shrink-0" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('B1 German Language Qualification') }}
                                </li>

                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-accent shrink-0" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('Advanced German Studies at University') }}
                                </li>

                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-accent shrink-0" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('3+ Years Teaching Experience') }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="aspect-[4/5] rounded-3xl overflow-hidden bg-gray-100 relative z-10 shadow-xl">
                        <img src="{{ asset('images/teacher.png') }}" alt="Our Teacher"
                            class="absolute inset-0 w-full h-full object-cover">
                        <div
                            class="absolute inset-0 bg-gradient-to-tr from-accent/20 to-transparent opacity-50 mix-blend-multiply pointer-events-none">
                        </div>
                    </div>
                    <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-accent rounded-3xl -z-10 opacity-20"></div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>