<div {{ $attributes->merge(['class' => 'card']) }}>
    @if(isset($header))
        <div class="px-6 py-4 border-b border-[#E5E5E5]">
            <h3 class="text-lg font-semibold text-gray-900">{{ $header }}</h3>
        </div>
    @endif
    
    <div class="p-6">
        {{ $slot }}
    </div>
    
    @if(isset($footer))
        <div class="px-6 py-4 border-t border-[#E5E5E5] bg-gray-50/50 rounded-b-2xl">
            {{ $footer }}
        </div>
    @endif
</div>
