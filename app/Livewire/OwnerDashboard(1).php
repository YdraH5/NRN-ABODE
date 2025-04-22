<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Report;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OwnerDashboard extends Component
{
    public function render()
    {

        return view('livewire.owner-dashboard');
    }
}
