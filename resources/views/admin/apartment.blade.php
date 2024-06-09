@section('title', 'Apartment Management')

<x-app-layout>
    @section('content')

    <x-slot name="header">
        <div class="flex justify-between items-center px-2">
            <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
                {{ __('Manage Apartment') }}
            </h2>
            {{-- toggle to open the modal form --}}
            <button class="" x-data x-on:click="$dispatch('open-modal',{name:'add-apartment'})">
                @include('buttons.add')
            </button> 
        </div>
    </x-slot>
        
    @livewire('apartment-form')
    <div class="py-2 max-w-full">
        <div class="mx-4 sm:px-4 md:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="flex flex-col">
                    @livewire('apartment-table')   
                </div>
            </div>
        </div>
    </div>
    
    @endsection
</x-app-layout>
