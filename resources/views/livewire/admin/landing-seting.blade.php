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

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Update Landing Page
        </button>
    </form>
</div>
