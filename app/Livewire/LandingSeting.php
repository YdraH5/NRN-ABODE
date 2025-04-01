<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LandingPage;

class LandingSeting extends Component
{
    public $discover_description, $designed_description, $neary_description, $apartment_description;

    public function mount()
    {
        // Load the existing report data
        $report = LandingPage::first();

        if ($report) {
            $this->discover_description = $report->discover_description;
            $this->designed_description = $report->designed_description;
            $this->neary_description = $report->neary_description;
            $this->apartment_description = $report->apartment_description;
        }
    }

    public function updateReport()
    {
        // Validate inputs
        $this->validate([
            'discover_description' => 'string',
            'designed_description' => 'string',
            'neary_description' => 'string',
            'apartment_description' => 'string',
        ]);

        // Find the first row, if it exists, update it
        $report = LandingPage::first();
        if ($report) {
            $report->update([
                'discover_description' => $this->discover_description,
                'designed_description' => $this->designed_description,
                'neary_description' => $this->neary_description,
                'apartment_description' => $this->apartment_description,
            ]);
        } else {
            // If no record exists, create one
            LandingPage::create([
                'discover_description' => $this->discover_description,
                'designed_description' => $this->designed_description,
                'neary_description' => $this->neary_description,
                'apartment_description' => $this->apartment_description,
            ]);
        }
        
        session()->flash('message', 'Landing page updated successfully!');
    }

    public function render()
    {
        return view('livewire.admin.landing-seting');
    }
}
