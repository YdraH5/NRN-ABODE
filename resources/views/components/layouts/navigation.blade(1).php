
<div class="no-print fixed w-full z-30 flex bg-[#343a40] p-2 items-center justify-center h-20 px-10">
  
  <div class="no-print flex">
    <button type="button" id="sidebarCollapse" class="no-print text-white p-2 rounded focus:outline-none">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
      </svg>
    </button>
    <!-- Sidebar -->
    <nav id="sidebar" class="no-print text-white w-64 min-h-screen fixed bg-[#212529] overflow-y-auto">
      <div class="no-print p-2 bg-[#343a40] px-4 sticky top-0">
        <img src="{{ asset('images/NRN LOGO.png') }}" style="height: 64px; width:128px" class="no-print sm:mx-4 lg:mx-6 lg:h-20 lg:w-60">
      </div>
      <div id="mobileLogo" class="no-print hidden fixed top-0 left-0 my-2 bg-[#212529]">
        <img src="{{ asset('images/NRN LOGO.png') }}" style="height: 40px; width:70px;" alt="Logo">
      </div>
      
      <ul class="no-print px-2 py-4">
        <li class="mb-4">
            <div class="hidden sm:-my-px sm:ms-10 sm:flex hover:text-black"> 
               @include('components.dashboard-icon')
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
            </div>
        </li>
        <li class="mb-4">
          <div class="hidden sm:-my-px sm:ms-10 sm:flex hover:text-black"> 
              <!-- Users Icon -->
             @include('components.user-icon')
              <x-nav-link wire:navigate :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                {{ __('Users') }}
              </x-nav-link>
          </div>
        </li>
        <li class="mb-4">
          <div class="hidden sm:-my-px sm:ms-10 sm:flex hover:text-black"> 
            <!-- Users Icon -->
            @include('components.apartment-icon')
            <x-nav-link wire:navigate :href="route('admin.apartment.index')" :active="request()->routeIs('admin.apartment.index')">
              {{ __('Apartments') }}
            </x-nav-link>
          </div>
        </li>
        <li class="mb-4">
          <div class="hidden sm:-my-px sm:ms-10 sm:flex hover:text-black"> 
            <!-- Users Icon -->
            @include('components.occupant-icon')
            <x-nav-link wire:navigate :href="route('admin.occupants.index')" :active="request()->routeIs('admin.occupants.index')">
              {{ __('Occupants') }}
            </x-nav-link>
          </div>
        </li>
        <li class="mb-4">
          <div class="hidden sm:-my-px sm:ms-10 sm:flex hover:text-black"> 
            <!-- Report Icon -->
            @include('components.report-icon')
            <x-nav-link wire:navigate :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.index')">
              {{ __('Complaints') }}
            </x-nav-link>
          </div>
        </li>
        <li class="mb-4">
          <div class="hidden sm:-my-px sm:ms-10 sm:flex hover:text-black"> 
            <!-- Reservation Icon -->
            @include('components.calendar-icon')
            <x-nav-link wire:navigate :href="route('admin.reserve.index')" :active="request()->routeIs('admin.reserve.index')">
              {{ __('Reservations') }}
            </x-nav-link>
          </div>
        </li>
        <li class="mb-4">
          <div class="hidden sm:-my-px sm:ms-10 sm:flex hover:text-black"> 
            <!-- Payments Icon -->
            @include('components.payment-icon')
            <x-nav-link wire:navigate :href="route('admin.payments.index')" :active="request()->routeIs('admin.payments.index')">
              {{ __('Payments') }}
            </x-nav-link>
          </div>
        </li>
        <li class="mb-4">
          <div class="hidden sm:-my-px sm:ms-10 sm:flex hover:text-black"> 
            <!-- Payments Icon -->
            @include('components.megaphone-icon')
            <x-nav-link wire:navigate :href="route('admin.announcement.index')" :active="request()->routeIs('admin.announcement.index')">
              {{ __('Announcements') }}
            </x-nav-link>
          </div>
        </li>
        <!-- Settings Dropdown -->
        <li class="mb-4">
          <div x-data="{ open: false }" class="relative">
            <!-- Dropdown Trigger -->
            <button 
              @click="open = !open" 
              class="flex items-center justify-between w-full px-4 py-2 text-white rounded-md hover:bg-gray-700 focus:outline-none transition duration-300">
              <span class="flex items-center">
                @include('components.settings-icon') <!-- Include your settings icon component -->
                <span class="ms-2 font-semibold">Settings</span>
              </span>
              <svg 
                xmlns="http://www.w3.org/2000/svg" 
                class="w-5 h-5 transform transition-transform duration-300" 
                :class="{'rotate-180': open}" 
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor" 
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <!-- Dropdown Menu -->
            <div 
              x-show="open" 
              x-collapse 
              x-cloak
              class="mt-2 bg-[#212529] text-white shadow-lg rounded-md overflow-hidden">
              <x-nav-link 
                wire:navigate 
                :href="route('admin.nearby-establishment.index')" 
                :active="request()->routeIs('admin.nearby-establishment.index')" 
                class="block px-4 py-2">
                {{ __('Nearby Establishments') }}
              </x-nav-link>
              <x-nav-link 
                wire:navigate 
                :href="route('admin.landing_page.index')" 
                :active="request()->routeIs('admin.landing_page.index')" 
                class="block px-4 py-2">
                {{ __('Landing Page') }}
              </x-nav-link>
              <x-nav-link 
                wire:navigate 
                :href="route('admin.logs.index')" 
                :active="request()->routeIs('admin.logs.index')" 
                class="block px-4 py-2 ">
                {{ __('Activity Logs') }}
              </x-nav-link>
            </div>
          </div>
        </li>

      </ul>
      
        <!-- Footer -->
      <footer class="p-1 bg-[#212529] text-gray-400 border-t border-gray-600">
        <p class="text-sm">&copy; NRN BUILDING</p>
        <p class="text-xs">All rights reserved.</p>
      </footer>
    </nav> 
  </div>
   <!-- SPACER -->
   <div class="no-print grow h-full flex items-center justify-center"></div>
   <!-- Settings Dropdown -->
   <div class="hidden md:flex sm:items-center sm:ms-6">                    
    <x-dropdown align="right" width="48">
        <x-slot name="trigger">
            <button class="inline-flex items-center px-3 py-2  text-sm leading-4 font-medium text-white hover:text-gray-700 transition ease-in-out duration-150">                                
                <div class="flex ">                
                    {{ Auth::user()->name }}
                </div>

                <div class="ms-1">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </button>
        </x-slot>

        <x-slot name="content">
            <x-dropdown-link wire:navigate :href="route('profile.edit')">
                {{ __('Profile') }}
            </x-dropdown-link>

            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-dropdown-link>
            </form>
        </x-slot>
    </x-dropdown>
</div>
  <div class="-me-2 flex items-center md:hidden">
    <nav x-data="{ open: false }">
      
      <button class="no-print w-14 h-14 relative focus:outline-none rounded text-gray-400 " @click="open = !open">
        <div class="block w-5 absolute left-6 top-1/2 transform -translate-x-1/2 -translate-y-1/2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </div>
      </button>
      <div class="absolute top-16 left-0 w-full bg-[#212529] z-10" x-show="open" @click.away="open = false">
          <ul class="py-4 overflow-y-auto max-h-80">
              <x-responsive-nav-link href="{{ route('dashboard') }}" 
                 active="{{ request()->routeIs('dashboard') }}" 
                 class="flex items-center px-4 py-2 text-white ">
                @include('components.dashboard-icon')
                Dashboard
              </x-responsive-nav-link>
  
              <x-responsive-nav-link  :href="route('admin.users.index')" 
                  :active="request()->routeIs('admin.users.index')"
                  class="flex items-center px-4 py-2 text-white ">
                  @include('components.users-icon')
                  Users
              </x-responsive-nav-link>

              <x-responsive-nav-link  href="{{ route('admin.apartment.index') }}" 
                  :active="request()->routeIs('admin.apartment.index')" 
                  class="flex items-center px-4 py-2 text-white ">
                  @include('components.apartment-icon') 
                  Aparment
              </x-responsive-nav-link>

              <x-responsive-nav-link  href="{{ route('admin.occupants.index') }}" 
                  :active="request()->routeIs('admin.occupants.index')" 
                  class="flex items-center px-4 py-2 text-white ">
                  @include('components.occupant-icon') 
                  Occupants
              </x-responsive-nav-link>
              
              <x-responsive-nav-link  href="{{ route('admin.reports.index') }}" 
                  :active="request()->routeIs('admin.reports.index')" 
                  class="flex items-center px-4 py-2 text-white ">
                  @include('components.report-icon') 
                  Complaints
              </x-responsive-nav-link>
              
              <x-responsive-nav-link  href="{{ route('admin.reserve.index') }}" 
                  :active="request()->routeIs('admin.reserve.index')" 
                  class="flex items-center px-4 py-2 text-white ">
                  @include('components.calendar-icon') 
                  Reserves
              </x-responsive-nav-link>

              <x-responsive-nav-link  href="{{ route('admin.announcement.index') }}" 
                  :active="request()->routeIs('admin.Announcement.index')" 
                  class="flex items-center px-4 py-2 text-white ">
                  @include('components.megaphone-icon') 
                  Announcements
              </x-responsive-nav-link>
              <x-responsive-nav-link  href="{{ route('admin.payments.index') }}" 
                  :active="request()->routeIs('admin.payments.index')" 
                  class="flex items-center px-4 py-2 text-white ">
                  @include('components.payment-icon') 
                  Payments
              </x-responsive-nav-link>
              <x-responsive-nav-link  href="{{route('profile.edit')}}" 
                  :active="request()->routeIs('profile.edit')" 
                  class="flex items-center px-4 py-2 text-white ">
                  @include('components.user-icon') 
                  Profile
              </x-responsive-nav-link>
              <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                        this.closest('form').submit();"
                         class="flex items-center px-4 py-2 text-white ">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-3">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                        </svg>
                        Log out
                </x-responsive-nav-link>
            </form>
          </ul>
      </div>
    </nav>
  </div>
</div>

  <div id="content" class="w-full py-16 px-2">
    <!-- Page Content -->

