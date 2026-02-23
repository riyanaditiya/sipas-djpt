<div>
    <flux:heading size="xl" level="1">{{ __('Tambah User') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">
        {{ __('Tambah data user') }}
    </flux:subheading>
    <flux:separator variant="subtle" />

    <section class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 mt-6">

        <form wire:submit.prevent="update" class="space-y-5">
            <!-- Nama -->
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                    Lengkap</label>
                <input type="text" id="name" wire:model="name"
                    class="w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 
                           dark:bg-gray-700 dark:border-gray-600 dark:text-white 
                           focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Masukkan nama lengkap">
                @error('name')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                <input type="email" id="email" wire:model="email" autocomplete="email"
                    class="w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 
                           dark:bg-gray-700 dark:border-gray-600 dark:text-white 
                           focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Masukkan email">
                @error('email')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                <input type="password" id="password" wire:model="password" autocomplete="new-password"
                    class="w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 
                              dark:bg-gray-700 dark:border-gray-600 dark:text-white 
                              focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Kosongkan password jika tidak diganti">
                @error('password')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- ConfirmPassword -->
            <div>
                <label for="confirm_password"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi Password</label>
                <input type="password" id="confirm_password" wire:model="confirm_password"
                    class="w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 
                           dark:bg-gray-700 dark:border-gray-600 dark:text-white 
                           focus:ring-primary-500 focus:border-primary-500">
                @error('confirm_password')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>


            <!-- Submit -->
            <div class="pt-4 flex justify-end gap-2">
                <!-- Tombol Kembali -->
                <a wire:navigate href="{{ route('user.index') }}"
                    class="inline-flex justify-center items-center px-5 py-2.5 
               text-sm font-medium text-white bg-gray-500 rounded-lg 
               hover:bg-gray-600 focus:ring-4 focus:ring-gray-200 
               dark:focus:ring-gray-700">
                    Kembali
                </a>

                <!-- Tombol Update -->
                <button type="submit" wire:loading.attr="disabled" wire:target="update"
                    class="relative inline-flex items-center justify-center
                    w-[110px] h-[42px]
                    text-sm font-medium text-white bg-[#0576a6] hover:bg-[#0054A3] rounded-lg
                    focus:ring-4 focus:ring-yellow-200
                    disabled:opacity-70 disabled:cursor-not-allowed
                    dark:focus:ring-yellow-900">

                    {{-- TEXT --}}
                    <span wire:loading.remove wire:target="update" class="absolute">
                        Update
                    </span>

                    {{-- SPINNER --}}
                    <svg wire:loading wire:target="update" class="absolute w-5 h-5 animate-spin text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4
                 a4 4 0 00-4 4H4z"></path>
                    </svg>
                </button>

            </div>

        </form>
    </section>
</div>
