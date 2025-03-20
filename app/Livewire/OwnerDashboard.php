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
    public $userCount;
    public $reportCount;
    public $vacantRooms;
    public $occupiedRooms;
    public $reservations;
    public $recentActivities;
    public $months;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->userCount = User::count();
        $this->reportCount = Report::count();
        $this->vacantRooms = DB::table('apartment')->whereNull('renter_id')->count();
        $this->occupiedRooms = DB::table('apartment')->whereNotNull('renter_id')->count();
        $this->reservations = DB::table('reservations')
            ->whereNotNull('user_id')
            ->whereDate('check_in', '>', Carbon::now())
            ->count();
        
        $this->recentActivities = Activity::with(['subject'])->latest()->take(10)->get();

        $monthlyRevenue = DB::table('payments')
            ->select(DB::raw('SUM(amount) as total'), DB::raw('MONTH(created_at) as month'))
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status', 'paid')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month');

        $this->months = collect(range(1, 12))->mapWithKeys(function ($month) use ($monthlyRevenue) {
            return [$month => $monthlyRevenue->get($month, 0)];
        });
    }

    public function render()
    {
        return view('livewire.owner-dashboard');
    }
}
