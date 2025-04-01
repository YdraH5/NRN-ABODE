<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use App\Models\Building;
use App\Models\Category;
use App\Models\DueDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;
use Livewire\WithPagination;
use Carbon\Carbon;
class OwnerDashboardController extends Controller
{   
    public function index()
    {
        $monthlyRevenue = DB::table('payments')
        ->select(DB::raw('SUM(amount) as total'), DB::raw('MONTH(created_at) as month'))
        ->whereYear('created_at', Carbon::now()->year)
        ->where('status', 'paid')
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->pluck('total', 'month');

    // Fill in missing months with 0
    $months = collect(range(1, 12))->mapWithKeys(function ($month) use ($monthlyRevenue) {
        return [$month => $monthlyRevenue->get($month, 0)];
    });

    // Fetch data for the dashboard
    $userCount = User::count();
    $reportCount = Report::count();
    $vacantRooms = DB::table('apartment')->whereNull('renter_id')->count();
    $occupiedRooms = DB::table('apartment')->whereNotNull('renter_id')->count();
    $reservations = DB::table('reservations')
        ->whereNotNull('user_id')
        ->whereDate('check_in', '>', Carbon::now())
        ->count();
    $recentActivities = Activity::with(['subject'])->latest()->paginate(20);

    // Payment Collection Data
    $paidCount = DueDate::where('status', 'paid')->count();
    $pendingCount = DueDate::where('status', 'pending')->count();
    $overdueCount = DueDate::where('status', '!=', 'paid')
        ->where('payment_due_date', '<', Carbon::today())
        ->count();

    // Complaint Status Data
    $openComplaints = Report::where('status', 'Pending')->count();
    $inProgressComplaints = Report::where('status', 'Ongoing')->count();
    $resolvedComplaints = Report::where('status', 'Fixed')->count();

    // Pass data to the view
    return view('owner.dashboard', compact(
        'userCount', 'reportCount', 'vacantRooms', 'occupiedRooms', 
        'reservations', 'recentActivities', 'months', 
        'paidCount', 'pendingCount', 'overdueCount',
        'openComplaints', 'inProgressComplaints', 'resolvedComplaints'
    ));
}
}
