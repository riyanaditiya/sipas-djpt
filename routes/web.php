<?php

use App\Models\User;
use App\Livewire\Dashboard;
use Laravel\Fortify\Features;
use App\Livewire\User\UserEdit;
use App\Livewire\User\UserIndex;
use App\Livewire\User\UserCreate;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\TwoFactor;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Livewire\Keputusan\KeputusanEdit;
use App\Livewire\Keputusan\KeputusanIndex;
use App\Livewire\DataDukung\DataDukungEdit;
use App\Livewire\Keputusan\KeputusanCreate;
use App\Livewire\DataDukung\DataDukungIndex;
use App\Livewire\DataDukung\DataDukungCreate;
use App\Livewire\DataDukungDetail\DataDukungDetailEdit;
use App\Livewire\DataDukungDetail\DataDukungDetailIndex;
use App\Livewire\DataDukungDetail\DataDukungDetailCreate;
use App\Livewire\Pejabat\PejabatCreate;
use App\Livewire\Pejabat\PejabatEdit;
use App\Livewire\Pejabat\PejabatIndex;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');

    Route::middleware('can:manage-users')->group(function () {
        Route::get('/users', UserIndex::class)->name('user.index');
        Route::get('/users/create', UserCreate::class)->name('user.create');
        Route::get('/users/edit/{uuid}', UserEdit::class)->name('user.edit');
    });

    Route::get('/keputusan',KeputusanIndex::class)->name('keputusan.index');
    Route::get('/keputusan/create', KeputusanCreate::class)->name('keputusan.create');
    Route::get('/keputusan/edit/{uuid}', KeputusanEdit::class)->name('keputusan.edit');

    Route::get('/keputusan/verify-reset/{uuid}', function ($uuid) {
        if (!request()->hasValidSignature()) abort(401);
        return redirect()->route('keputusan.index', ['reset_verified' => true, 'uuid' => $uuid]);
    })->name('passcode.reset.verify');

    Route::get('/data-dukung', DataDukungIndex::class)->name('data-dukung.index');
    Route::get('/data-dukung/create', DataDukungCreate::class)->name('data-dukung.create');
    Route::get('/data-dukung/edit/{uuid}', DataDukungEdit::class)->name('data-dukung.edit');

    Route::get('/data-dukung/detail/{uuid}', DataDukungDetailIndex::class)->name('details.index');
    Route::get('/data-dukung/detail/create/{uuid}', DataDukungDetailCreate::class)->name('details.create');
    Route::get('/data-dukung/detail/edit/{uuid}', DataDukungDetailEdit::class)->name('details.edit');

    Route::get('/pejabat', PejabatIndex::class)->name('pejabat.index');
    Route::get('/pejabat/create', PejabatCreate::class)->name('pejabat.create');
    Route::get('/pejabat/edit/{uuid}', PejabatEdit::class)->name('pejabat.edit');




});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
