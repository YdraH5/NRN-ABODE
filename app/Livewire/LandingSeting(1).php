<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\LandingPage;
use Illuminate\Support\Facades\Storage;

class LandingSeting extends Component
{
    use WithFileUploads;

    public $discover_description, $designed_description, $neary_description, $apartment_description;
    public $gcash_number;
    public $gcash_qr_image;
    public $new_gcash_qr_image;

    public function mount()
    {
        // Load the existing report data
        $report = LandingPage::first();

        if ($report) {
            $this->discover_description = $report->discover_description;
            $this->designed_description = $report->designed_description;
            $this->neary_description = $report->neary_description;
            $this->apartment_description = $report->apartment_description;
            $this->gcash_number = $report->gcash_number;
            $this->gcash_qr_image = $report->gcash_qr_image;
        }
    }

    public function updateReport()
    {
        // Validate inputs
        $this->validate([
            'discover_description' => 'required|string',
            'designed_description' => 'required|string',
            'neary_description' => 'required|string',
            'apartment_description' => 'required|string',
            'gcash_number' => 'nullable|string|regex:/^09\d{9}$/',
            'new_gcash_qr_image' => 'nullable|image|max:2048', // 2MB max
        ]);

        // Handle file upload if new image is provided
        if ($this->new_gcash_qr_image) {
            // Delete old image if exists
            if ($this->gcash_qr_image) {
                Storage::delete('public/' . $this->gcash_qr_image);
            }
            
            // Store new image
            $imagePath = $this->new_gcash_qr_image->store('gcash-qr', 'public');
            $this->gcash_qr_image = $imagePath;
        }

        // Find the first row, if it exists, update it
        $report = LandingPage::first();
        if ($report) {
            $report->update([
                'discover_description' => $this->discover_description,
                'designed_description' => $this->designed_description,
                'neary_description' => $this->neary_description,
                'apartment_description' => $this->apartment_description,
                'gcash_number' => $this->gcash_number,
                'gcash_qr_image' => $this->gcash_qr_image,
            ]);
        } else {
            // If no record exists, create one
            LandingPage::create([
                'discover_description' => $this->discover_description,
                'designed_description' => $this->designed_description,
                'neary_description' => $this->neary_description,
                'apartment_description' => $this->apartment_description,
                'gcash_number' => $this->gcash_number,
                'gcash_qr_image' => $this->gcash_qr_image,
            ]);
        }
        
        // Clear the temporary file upload property
        $this->reset('new_gcash_qr_image');
        
        session()->flash('message', 'Landing page updated successfully!');
    }

    public function render()
    {
        return view('livewire.admin.landing-seting');
    }
}