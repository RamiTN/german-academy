@props(['color' => 'gray'])

@php
    $classes = match($color) {
        'green' => 'bg-green-100 text-green-800',
        'red' => 'bg-red-100 text-red-800',
        'amber' => 'bg-amber-100 text-amber-800',
        'blue' => 'bg-blue-100 text-blue-800',
        'indigo' => 'bg-indigo-100 text-indigo-800',
        'purple' => 'bg-purple-100 text-purple-800',
        'emerald' => 'bg-emerald-100 text-emerald-800',
        'teal' => 'bg-teal-100 text-teal-800',
        'accent' => 'bg-accent-subtle text-accent-hover',
        default => 'bg-gray-100 text-gray-800',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium $classes"]) }}>
    {{ $slot }}
</span>
