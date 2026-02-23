<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <flux:navlist>
            <flux:navlist.item :href="route('profile.edit')" :current="request()->routeIs('profile.edit')"
                wire:navigate>{{ __('Profil') }}</flux:navlist.item>
            <flux:navlist.item :href="route('user-password.edit')" :current="request()->routeIs('user-password.edit')"
                wire:navigate>{{ __('Kata sandi') }}
            </flux:navlist.item>
            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <flux:navlist.item :href="route('two-factor.show')" :current="request()->routeIs('two-factor.show')"
                    wire:navigate>{{ __('Otentikasi dua faktor') }}
                </flux:navlist.item>
            @endif
            <flux:navlist.item :href="route('appearance.edit')" :current="request()->routeIs('appearance.edit')"
                wire:navigate>{{ __('Tampilan') }}</flux:navlist.item>
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
