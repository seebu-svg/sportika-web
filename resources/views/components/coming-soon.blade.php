@props([
    'title' => '',
    'description' => 'This page is coming soon. We are working hard to bring you the best experience.',
])

<div class="flex flex-col items-center justify-center py-24 text-center">
    <div class="mb-6 rounded-full bg-accent-400/10 p-5">
        <svg class="size-10 text-accent-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.124h.008v.008h-.008v-.008Z" />
        </svg>
    </div>
    <h3 class="font-display text-2xl uppercase tracking-wide text-white">Coming Soon</h3>
    <p class="mt-3 max-w-md text-slate-400">{{ $description }}</p>
    <a href="{{ route('home') }}" class="mt-6 rounded-full bg-accent-400 px-6 py-2.5 text-sm font-bold uppercase tracking-wider text-pitch-950 transition hover:bg-accent-300">
        Back to Home
    </a>
</div>
