{{-- Reusable section heading --}}
@props(['title', 'description' => '', 'tag' => 'h2'])

<div class="flex items-start justify-between gap-3.5 mb-4">
    <div>
        @if($tag === 'h3')
            <h3 class="m-0 mb-1 font-display text-[clamp(1.1rem,1.9vw,1.3rem)] font-bold">{{ $title }}</h3>
        @else
            <h2 class="m-0 mb-1 font-display text-[clamp(1.1rem,1.9vw,1.3rem)] font-bold">{{ $title }}</h2>
        @endif

        @if($description)
            <p class="m-0 text-muted text-[0.94rem]">{{ $description }}</p>
        @endif
    </div>
    {{ $slot }}
</div>
