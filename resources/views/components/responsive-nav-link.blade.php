@props(['active'])

@php
$classes = 'block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}
   style="color: {{ ($active ?? false) ? 'var(--accent)' : 'var(--text-muted)' }}; border-left-color: {{ ($active ?? false) ? 'var(--accent)' : 'transparent' }}; background: {{ ($active ?? false) ? '#eef2ff' : 'transparent' }};"
   onmouseover="this.style.color='var(--text)'; this.style.backgroundColor='var(--bg)'; this.style.borderLeftColor='var(--border)';"
   onmouseout="this.style.color='{{ ($active ?? false) ? 'var(--accent)' : 'var(--text-muted)' }}'; this.style.backgroundColor='{{ ($active ?? false) ? '#eef2ff' : 'transparent' }}'; this.style.borderLeftColor='{{ ($active ?? false) ? 'var(--accent)' : 'transparent' }}';">
    {{ $slot }}
</a>
