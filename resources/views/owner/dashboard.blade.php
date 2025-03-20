@section('title', 'Dashboard')

@section('content')
<x-owner-layout>
  <div class="py-6">
    <div class="min-w-full mx-auto">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="flex flex-col">
          <div class="flex items-center gap-4 mb-4 p-2 bg-gray-50 rounded-lg shadow-sm">
            <h1 class="text-2xl font-semibold text-black">Admin Dashboard</h1>
          </div>

          @livewire('owner-dashboard') 

        
        
        </div>
      </div>
    </div>
  </div>


  @stop

</x-owner-layout>