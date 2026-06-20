@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}
   style="color: {{ ($active ?? false) ? 'var(--accent)' : 'var(--text-muted)' }}; border-bottom-color: {{ ($active ?? false) ? 'var(--accent)' : 'transparent' }};"
   onmouseover="this.style.color='var(--text)'; this.style.borderBottomColor='var(--border)';"
   onmouseout="this.style.color='{{ ($active ?? false) ? 'var(--accent)' : 'var(--text-muted)' }}'; this.style.borderBottomColor='{{ ($active ?? false) ? 'var(--accent)' : 'transparent' }}';">
    {{ $slot }}
</a>
