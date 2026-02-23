<?php

namespace App\Livewire;

use App\Models\Pejabat;
use Livewire\Component;
use App\Models\Keputusan;
use App\Models\DataDukung;
use App\Models\DataDukungDetail;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard', [
            'countKeputusan'  => Keputusan::count(),
            'countDataDukung' => DataDukung::count(),
            'countDetails'    => DataDukungDetail::count(),
            'countPejabat'    => Pejabat::count(),
        ]);

    }
}
