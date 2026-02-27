{{-- Notifikasi Sukses --}}
@if (session()->has('success'))
    <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms x-init="setTimeout(() => show = false, 3000)"
        class="fixed top-5 right-5 flex items-center gap-3
           bg-green-600 text-white px-5 py-3
           rounded-lg shadow-lg z-[9999]">
        <div class="flex h-9 w-9 items-center justify-center
                rounded-full bg-white/20">
            <svg class="w-5 h-5 animate-[pop_0.4s_ease-out]" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <span class="text-sm font-semibold tracking-wide">
            {{ session('success') }}
        </span>
    </div>

    <style>
        @keyframes pop {
            0% {
                transform: scale(0.6);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
@endif
