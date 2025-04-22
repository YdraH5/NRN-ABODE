<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Payment;
use App\Models\Appartment;
use App\Models\Category;
use App\Models\User;
use App\Models\DueDate;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentAccepted;
class PaymentTable extends Component
{
    use WithPagination;
    public $search;
    public $page = 'validation';
    public $sortDirection="DESC";
    public $sortColumn ="created_at";
    public $perPage = 10;
    public $currentReceipt;
    public $payment_id;
    public $currentStatus;
    public $modal = false;
    public function doSort($column){
        if($this->sortColumn === $column){
            $this->sortDirection = ($this->sortDirection === 'ASC')? 'DESC':'ASC';
            return;
        }
        $this->sortColumn = $column;
        $this->sortDirection = 'ASC';
    }
    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination when search input is updated
    }
    public function showReceipt($receipt,$payment_id,$status)
    {
        $this->modal = true;
        $this->currentReceipt = $receipt;
        $this->payment_id = $payment_id;
        $this->currentStatus = $status;
    }
    public function close()
    {
        $this->modal = false;
        $this->currentReceipt = null;
        $this->payment_id =null;
        $this->currentStatus =null;
        $this->reset(['currentReceipt','payment_id','currentStatus']); // Reset specific property
    }
    public function approve($payment_id)
    {
        $payment = Payment::find($payment_id);
    
        if (!$payment) {
            return redirect()->back()->with('error', 'Payment record not found.');
        }
    
        $user = User::find($payment->user_id);
    
        if (!$user) {
            return redirect()->back()->with('error', 'User associated with this payment not found.');
        }
    
        if ($payment->category === 'Rent Fee') {
            $this->updatePaymentAndDueDate($payment_id, 'paid');
            $this->sendPaymentAcceptedEmail($user, $payment);
        } elseif ($payment->category === 'Reservation fee') {
            $this->updatePaymentStatus($payment_id, 'paid');
            
            Reservation::where('id', $payment->reservation_id)
                ->update(['status' => 'approved']);
            
            Appartment::where('id', $payment->apartment_id)
                ->update([
                    'status' => 'Reserved',
                    'renter_id' => $payment->user_id
                ]);
            
            User::where('id', $payment->user_id)
                ->update(['role' => 'reserve']);
            
            $this->sendPaymentAcceptedEmail($user, $payment);
        }
    
        session()->flash('success', 'Payment Approved');
    }
    private function updatePaymentAndDueDate($payment_id, $status)
    {
        Payment::where('id', $payment_id)->update(['status' => $status]);
        DueDate::where('payment_id', $payment_id)->update(['status' => $status]);
    }
    
    private function updatePaymentStatus($payment_id, $status)
    {
        Payment::where('id', $payment_id)->update(['status' => $status]);
    }
    
    private function sendPaymentAcceptedEmail($user, $payment)
    {
        // Fetch the due date if it exists, particularly for Rent Fee category
        $dueDate = DueDate::where('payment_id', $payment->id)->first();
    
        // Send an email notification
        Mail::to($user->email)->send(new PaymentAccepted([
            'name' => $user->name,
            'payment' => $payment->amount,
            'category' => $payment->category,
            'payment_method' => $payment->payment_method,
            'payment_due_date' => $dueDate ? $dueDate->payment_due_date : null, // Add due date if applicable
        ]));
    }
    
    public function reject($payment_id)
    {
        $payment = Payment::find($payment_id);
        
        if ($payment->category === 'Rent Fee') {
            $this->updatePaymentAndDueDate($payment_id, 'Rejected');
            
            // Optional: Send notification about rejection
            // Mail::to($payment->user->email)->send(new PaymentRejected(...));
            
        } elseif ($payment->category === 'Reservation fee') {
            $this->updatePaymentStatus($payment_id, 'Rejected');
            
            // Reset reservation and apartment status if needed
            Reservation::where('id', $payment->reservation_id)
                ->update(['status' => 'Rejected']);
                
            Appartment::where('id', $payment->apartment_id)
                ->update([
                    'status' => 'Available',
                    'renter_id' => null
                ]);
                
            User::where('id', $payment->user_id)
                ->update(['role' => 'tenant']); // or whatever default role
        }
        
        session()->flash('success', 'Payment Rejected');
    }
    public function send()
    {
        // Get all apartments where the renter_id is set
        $apartments = DB::table('apartment')
            ->whereNotNull('renter_id')
            ->get();
    
        foreach ($apartments as $apartment) {
            $price = Category::find($apartment->category_id);
            // Get the renter associated with the apartment
            $renter = User::find($apartment->renter_id);
            
            if ($renter) {
                // Create a payment record for the renter
                Payment::create([
                    'user_id' => $renter->id,
                    'apartment_id' => $apartment->id,
                    'amount' => $price->price, // You might need to set this to the appropriate amount
                    'payment_method' => '', // You might want to adjust this depending on your requirements
                    'status' => 'unpaid',
                    'category'=>'Rent Fee',
                ]);
            }
        }
        session()->flash('success', 'BIlls for this month succesfully sent to renters.');

    }
    
    
    public function render()
{
    // Start the query with the Payment model and join the necessary relationships
    $query = Payment::with(['user', 'apartment'])
        ->select(
            'users.name as user_name',
            'payments.id',
            'payments.category',
            'payments.amount',
            'payments.receipt',
            'payments.created_at',
            'payments.transaction_id',
            'payments.payment_method',
            'payments.status',
            'buildings.name as building_name',
            'apartment.room_number',
        )
        ->leftJoin('users', 'users.id', '=', 'payments.user_id')
        ->leftJoin('apartment', 'apartment.id', '=', 'payments.apartment_id')
        ->leftJoin('buildings', 'buildings.id', '=', 'apartment.building_id')
        ->orderBy($this->sortColumn, $this->sortDirection);

    // Filter based on the search
    if (!empty($this->search)) {
        $query->where(function($query) {
            $query->where('users.name', 'like', '%' . $this->search . '%')
                ->orWhere('payments.category', 'like', '%' . $this->search . '%')
                ->orWhere('payments.transaction_id', 'like', '%' . $this->search . '%')
                ->orWhere('payments.payment_method', 'like', '%' . $this->search . '%')
                ->orWhere('payments.status', 'like', '%' . $this->search . '%')
                ->orWhere('buildings.name', 'like', '%' . $this->search . '%')
                ->orWhere('payments.created_at', 'like', '%' . $this->search . '%')
                ->orWhere('apartment.room_number', 'like', '%' . $this->search . '%');
        });
    }

    // Execute the query and return the results
    $payments = $query->paginate($this->perPage);

    // Calculate earnings for this month and last month
    $currentMonthRentalEarnings = Payment::where('category', 'rent fee')
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->sum('amount');

    $lastMonthRentalEarnings = Payment::where('category', 'rent fee')
        ->whereMonth('created_at', now()->subMonth()->month)
        ->whereYear('created_at', now()->subMonth()->year)
        ->sum('amount');

    $currentMonthReservationEarnings = Payment::where('category', 'reservation fee')
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->sum('amount');

    $lastMonthReservationEarnings = Payment::where('category', 'reservation fee')
        ->whereMonth('created_at', now()->subMonth()->month)
        ->whereYear('created_at', now()->subMonth()->year)
        ->sum('amount');

    // Determine the maximum value across all datasets
    $maxValue = max(
        $currentMonthRentalEarnings,
        $lastMonthRentalEarnings,
        $currentMonthReservationEarnings,
        $lastMonthReservationEarnings
    );

    // Add a larger margin (e.g., 40% instead of 20%) to ensure more space above the bars
$adjustedMaxValue = ceil($maxValue * 1.4); // Increase the margin to 40%

// Generate QuickChart URLs
$rentalChartUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode([
    'type' => 'bar',
    'data' => [
        'labels' => ['Last Month', 'This Month'],
        'datasets' => [
            [
                'label' => 'Rental Fee Earnings (₱)',
                'data' => [$lastMonthRentalEarnings, $currentMonthRentalEarnings],
                'backgroundColor' => ['rgba(54, 162, 235, 0.6)', 'rgba(75, 192, 192, 0.6)'],
                'borderColor' => ['rgba(54, 162, 235, 1)', 'rgba(75, 192, 192, 1)'],
                'borderWidth' => 1,
            ],
        ],
    ],
    'options' => [
        'scales' => [
            'y' => [
                'beginAtZero' => true,
                'max' => $adjustedMaxValue, // Set adjusted max value with extra margin
            ],
        ],
        'plugins' => [
            'datalabels' => [
                'display' => true,
                'anchor' => 'end',
                'align' => 'end',
                'color' => '#333333',
                'font' => [
                    'size' => 14,
                    'weight' => 'bold',
                ],
                'formatter' => function($value, $context) {
                    return '₱' . number_format($value, 2);
                },
            ],
        ],
    ],
])) . '&w=400&h=300';

// Apply similar changes to the reservation chart URL
$reservationChartUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode([
    'type' => 'bar',
    'data' => [
        'labels' => ['Last Month', 'This Month'],
        'datasets' => [
            [
                'label' => 'Reservation Fee Earnings (₱)',
                'data' => [$lastMonthReservationEarnings, $currentMonthReservationEarnings],
                'backgroundColor' => ['rgba(153, 102, 255, 0.6)', 'rgba(255, 159, 64, 0.6)'],
                'borderColor' => ['rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'],
                'borderWidth' => 1,
            ],
        ],
    ],
    'options' => [
        'scales' => [
            'y' => [
                'beginAtZero' => true,
                'max' => $adjustedMaxValue, // Set adjusted max value with extra margin
            ],
        ],
        'plugins' => [
            'datalabels' => [
                'display' => true,
                'anchor' => 'end',
                'align' => 'end',
                'color' => '#333333',
                'font' => [
                    'size' => 14,
                    'weight' => 'bold',
                ],
                'formatter' => function($value, $context) {
                    return '₱' . number_format($value, 2);
                },
            ],
        ],
    ],
])) . '&w=400&h=300';
        // Conditionally render the correct view based on user role
        if (auth()->user()->role === 'admin') {
            return view('livewire.admin.payment-table', compact('payments', 'rentalChartUrl', 'reservationChartUrl'));

        } elseif (auth()->user()->role === 'owner') {
            return view('livewire.owner.payment-table', compact('payments', 'rentalChartUrl', 'reservationChartUrl'));

        } else {
            // Handle if user doesn't have the right role
            abort(403, 'Unauthorized action.');
        }

}
 
}
