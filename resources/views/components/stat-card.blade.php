@props(['title', 'value', 'icon' => null, 'color' => 'primary'])

@php
    $iconBg = match($color) {
        'green'   => 'bg-green-100 text-green-600',
        'amber'   => 'bg-amber-100 text-amber-600',
        'red'     => 'bg-red-100 text-red-600',
        'purple'  => 'bg-purple-100 text-purple-600',
        default   => 'bg-primary-100 text-primary-700',
    };
@endphp

<div class="stat-card">
    @if($icon)
        <div class="w-12 h-12 rounded-xl {{ $iconBg }} flex items-center justify-center flex-shrink-0">
            {!! $icon !!}
        </div>
    @endif
    <div>
        <p class="text-sm text-gray-500 font-medium">{{ $title }}</p>
        <p class="text-2xl font-heading font-bold text-gray-900 mt-0.5">{{ $value }}</p>
    </div>
</div>
