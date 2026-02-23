<div>
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms x-init="setTimeout(() => show = false, 3000)"
            class="fixed top-5 right-5 flex items-center gap-3
           bg-green-500 text-white px-5 py-3
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


    <div class="relative mb-6 w-full">
        <div class="flex items-start gap-5 mb-6">
            {{-- Ikon Statis dengan Shadow Halus --}}
            <div class="flex-shrink-0">
                <div
                    class="flex items-center justify-center size-12 rounded-xl bg-gradient-to-tr from-blue-50 to-white dark:from-blue-500/10 dark:to-transparent border border-blue-100 dark:border-blue-500/20 shadow-sm">
                    <flux:icon.users variant="outline" class="size-6 text-blue-600 dark:text-blue-400" />
                </div>
            </div>

            {{-- Judul & Subheading --}}
            <div class="flex flex-col gap-1">
                <flux:heading size="xl" level="1"
                    class="font-extrabold tracking-tight text-slate-900 dark:text-white leading-tight">
                    {{ __('Data Pengguna') }}
                </flux:heading>

                <flux:subheading size="lg" class="hidden sm:block text-slate-500 dark:text-slate-400 font-medium">
                    {{ __('Manajemen akun pengguna sistem') }}
                </flux:subheading>
            </div>
        </div>
        <flux:separator variant="subtle" />



        <!-- Start coding here -->
        <div>
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden mt-5 mb-2">
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2">
                        <form wire:submit="search" class="flex items-center">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                        fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input wire:model.live.debounce.250ms="query" type="text" id="simple-search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#00A2E9] focus:border-[#00A2E9] block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"
                                    placeholder="Cari user berdasarkan nama atau email...">
                            </div>
                        </form>
                    </div>

                    <div
                        class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <a wire:navigate href="{{ route('user.create') }}"
                            class="flex items-center justify-center text-white bg-[#0576a6] hover:bg-[#0054A3] font-medium rounded-lg text-sm px-4 py-2 focus:outline-none">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Tambah Pengguna
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-4">Nama</th>
                                <th scope="col" class="px-4 py-3">Email</th>

                                <th scope="col" class="px-4 py-3 text-center">Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3">{{ $user->name }}</td>
                                    <td class="px-4 py-3">{{ $user->email }}</td>

                                    <td class="px-4 py-3 flex items-center justify-center">
                                        <a wire:navigate href="{{ route('user.edit', $user->uuid) }}"
                                            class="p-2 text-yellow-600 bg-yellow-50 dark:bg-yellow-500/10 rounded-lg hover:bg-yellow-100 transition-colors me-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button wire:click="confirmDelete('{{ $user->uuid }}')"
                                            class="p-2 text-red-600 bg-red-50 dark:bg-red-500/10 rounded-lg hover:bg-red-100 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-12 text-center">
                                        <svg class="mx-auto w-16 h-16 text-gray-400 dark:text-gray-500"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.75 9.75L14.25 14.25M14.25 9.75L9.75 14.25M21 12A9 9 0 1 1 3 12a9 9 0 0 1 18 0Z" />
                                        </svg>
                                        <h3 class="mt-4 text-lg font-semibold text-gray-700 dark:text-gray-300">
                                            Data
                                            tidak
                                            ditemukan</h3>
                                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                            Coba masukkan kata kunci lain atau periksa kembali pencarian Anda.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
            {{ $users->links() }}
        </div>


        {{-- Modal Delete --}}
        @if ($deleteUuid)
            <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-lg w-100 p-6">
                    <h2 class="text-lg font-semibold text-gray-800">Konfirmasi Hapus</h2>
                    <p class="mt-2 text-gray-600">Apakah Anda yakin ingin menghapus data ini?</p>
                    <div class="mt-4 flex justify-end gap-3">
                        <button wire:click="$set('deleteUuid', null)"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                        <button wire:click="delete"
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Hapus</button>
                    </div>
                </div>
            </div>
        @endif
    </div>



</div>
