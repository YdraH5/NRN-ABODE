<div class="p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-xl font-bold mb-4">Update Landing Page</h2>

    @if (session()->has('message'))
        <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif
        
    <form wire:submit.prevent="updateReport">
        <div class="mb-4">
            <label class="block text-sm font-medium">Discover Description</label>
            <textarea wire:model="discover_description" class="w-full p-2 border rounded"></textarea>
            @error('discover_description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Designed Description</label>
            <textarea wire:model="designed_description" class="w-full p-2 border rounded"></textarea>
            @error('designed_description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Neary Description</label>
            <textarea wire:model="neary_description" class="w-full p-2 border rounded"></textarea>
            @error('neary_description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Apartment Description</label>
            <textarea wire:model="apartment_description" class="w-full p-2 border rounded"></textarea>
            @error('apartment_description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- GCash Number Field -->
        <div class="mb-4">
            <label class="block text-sm font-medium">GCash Number</label>
            <input type="text" wire:model="gcash_number" class="w-full p-2 border rounded">
            @error('gcash_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- GCash QR Image Field -->
        <div class="mb-4">
            <label class="block text-sm font-medium">GCash QR Code</label>
            
            <!-- Display current image if exists -->
            @if($gcash_qr_image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $gcash_qr_image) }}" alt="GCash QR Code" class="h-32">
                    <p class="text-xs text-gray-500 mt-1">Current QR Code</p>
                </div>
            @endif
            
            <!-- File input for new image -->
            <input type="file" wire:model="new_gcash_qr_image" class="w-full p-2 border rounded">
            @error('new_gcash_qr_image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Update Landing Page
        </button>
    </form>
</div>