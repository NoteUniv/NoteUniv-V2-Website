@props(['active'])

@php
$classes = $active ?? false ? 'flex items-center text-nu-secondary' : 'flex items-center hover:text-nu-secondary';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
