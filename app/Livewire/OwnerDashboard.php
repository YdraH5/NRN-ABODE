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
        $userCount = User::count();
        $reportCount = Report::count();
        $vacantRooms = DB::table('apartment')->whereNull('renter_id')->count();
        $occupiedRooms = DB::table('apartment')->whereNotNull('renter_id')->count();
        $reservations = DB::table('reservations')
            ->whereNotNull('user_id')
            ->whereDate('check_in', '>', Carbon::now())
            ->count();
        
        $recentActivities = Activity::with(['subject'])->latest()->take(10)->get();

        $monthlyRevenue = DB::table('payments')
            ->select(DB::raw('SUM(amount) as total'), DB::raw('MONTH(created_at) as month'))
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status', 'paid')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month');

        $months = collect(range(1, 12))->mapWithKeys(function ($month) use ($monthlyRevenue) {
            return [$month => $monthlyRevenue->get($month, 0)];
        });

        return view('livewire.owner-dashboard', compact(
            'userCount', 'reportCount', 'vacantRooms', 
            'occupiedRooms', 'reservations', 'recentActivities', 'months'
        ));
    }
}
