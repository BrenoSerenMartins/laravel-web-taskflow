<div x-data="{ open: @js($open ?? false) }">
    <!-- Trigger Button -->
    <div>
        <button @click="open = true" class="{{ $triggerClass ?? 'btn' }}">
            {{ $trigger }}
        </button>
    </div>

    <!-- Modal Content -->
    <div x-show="open" x-cloak class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
        <!-- Modal Inner (Do not close when clicked inside this) -->
        <div @click.away="open = false" class="bg-white rounded-lg p-6 w-full max-w-md relative">
            <!-- Close Button (X) -->
            <button @click="open = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Modal Title -->
            <h2 class="text-xl font-bold mb-4">{{ $title }}</h2>

            <!-- Modal Slot (Content passed from the calling page) -->
            {{ $slot }}

        </div>
    </div>
</div>
