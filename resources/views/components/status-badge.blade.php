@props(['status'])

@php
    $classes = match($status) {
        'Baru'     => 'badge badge-baru',
        'Ditinjau' => 'badge badge-ditinjau',
        'Selesai'  => 'badge badge-selesai',
        default    => 'badge bg-gray-100 text-gray-700',
    };
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>{{ $status }}</span>
