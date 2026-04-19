@props(['title', 'description' => '', 'tag' => 'h2'])

<div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:1rem">
    <div>
        @if($tag === 'h3')
            <h3 style="margin:0 0 .2rem;font-size:.95rem;font-weight:700;color:var(--color-gray-900)">{{ $title }}</h3>
        @else
            <h2 style="margin:0 0 .2rem;font-size:1rem;font-weight:700;color:var(--color-gray-900)">{{ $title }}</h2>
        @endif
        @if($description)
            <p style="margin:0;font-size:.8rem;color:var(--color-gray-500)">{{ $description }}</p>
        @endif
    </div>
    {{ $slot }}
</div>
