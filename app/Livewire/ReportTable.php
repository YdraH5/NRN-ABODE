<?php

namespace App\Livewire;
use App\Models\Report;
use Livewire\Component;
use Livewire\Attributes\Validate; 
use Illuminate\Support\Facades\DB;
class ReportTable extends Component
{
    public $search = "";
    public Report $selectedReport;

    #[Validate('required|min:5|max:50')] 
    public $status = '';
    public $id;
    public function edit($id){
        $this->id = $id;
    }
    public function action()
    {
        $this->validate([
            'status' => 'required|min:5|max:50',
        ]);
        $update = DB::table('reports')
                    ->where('id', $this->id)
                    ->update(['status' => $this->status]);
            if ($update) {
                $this->reset(); // Reset the component if the update was successful
                 return redirect()->route('admin.reports')->with('success', 'Report Action submitted successfully');
                } else {
                    return redirect()->back()->withInput()->withErrors(['status' => 'Failed to update status']); 
            }                
    }
    public function render()
    {
        $query = DB::table('reports')
            ->leftJoin('users', 'users.id', '=', 'reports.user_id')
            ->leftJoin('apartment', 'apartment.renter_id', '=', 'reports.user_id')
            ->select(
                'users.name',
                'reports.id',
                'reports.report_category',
                'apartment.building',
                'reports.description',
                'reports.status',
                'reports.ticket',
                'apartment.room_number',
                'reports.created_at as date'
            )
            ->orderByRaw("CASE WHEN reports.status = 'Solved' THEN 1 ELSE 0 END")
            ->orderBy('date', 'asc');        
        // Filter based on the search search
        if (!empty($this->search)) {
            $query->where('users.name', 'like', '%' . $this->search . '%')
                ->orWhere('reports.report_category', 'like', '%' . $this->search . '%')
                ->orWhere('reports.description', 'like', '%' . $this->search . '%')
                ->orWhere('reports.status', 'like', '%' . $this->search . '%')
                ->orWhere('reports.ticket', 'like', '%' . $this->search . '%')
                ->orWhere('reports.created_at', 'like', '%' . $this->search . '%')
                ->orWhere('apartment.room_number', 'like', '%' . $this->search . '%');
                
        }

        $reports = $query->cursorPaginate(10);

        return view('livewire.admin.report-table', compact('reports'));
    }
}
