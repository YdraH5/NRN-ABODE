@section('title', 'Category Management')

@section('content')
<x-owner-layout>
<div class="flex justify-end px-10 h-5"> 

@livewire('category-form') 

    <div class="py-4">
        <div class="min-w-full mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="flex flex-col">
                    @livewire('category-table')   
                </div>
            </div>
        </div>
    </div>


    @stop           
</x-owner-layout>
