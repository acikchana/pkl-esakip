@props(['href', 'active' => false])

<a href="{{ $href }}"
   {{ $attributes->merge(['class' => 'flex items-center gap-2.5 px-3 py-2.5 rounded-md text-sm font-medium transition-colors '
        . ($active
            ? 'bg-white/10 text-white'
            : 'text-white/60 hover:bg-white/5 hover:text-white')]) }}>
    {{ $slot }}
</a>