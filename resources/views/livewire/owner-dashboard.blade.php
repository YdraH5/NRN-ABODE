<div>
    <section class="text-gray-700 body-font mx-4">
        <div class="container px-4 py-4 mx-auto">
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 xl:grid-cols-4 gap-4 text-center">
            @foreach([
              [
                  'route' => '/admin/users',
                  'icon' => 'user',
                  'count' => \App\Models\Reservation::whereHas('apartment', function ($query) {
                      $query->whereColumn('reservations.user_id', 'apartment.renter_id');
                  })->sum('occupants'),
                  'label' => 'Occupants',
                  'color' => 'text-indigo-500'
              ],
              ['route' => 'admin/reports', 'icon' => 'report', 'count' => \App\Models\Report::count(), 'label' => 'Reports', 'color' => 'text-red-500'],
              ['route' => 'admin/apartment', 'icon' => 'room', 'count' => $vacantRooms, 'label' => 'Vacant Room', 'color' => 'text-green-500'],
              ['route' => 'admin/reservations', 'icon' => 'reservation', 'count' => \Illuminate\Support\Facades\DB::table('reservations')->whereNotNull('user_id')->whereDate('check_in', '>', \Carbon\Carbon::now())->count(), 'label' => 'Reservations', 'color' => 'text-indigo-500']
            ] as $item)
              <div class="p-4">
                <a href="{{ $item['route'] }}">
                  <div class="border-2 border-gray-600 px-4 py-6 rounded-lg transform transition duration-500 hover:scale-105">
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="{{ $item['color'] }} w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
                      @switch($item['icon'])
                        @case('user')
                          <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                          <circle cx="9" cy="7" r="4"></circle>
                          <path d="M23 21v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75"></path>
                          @break
                        @case('report')
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                          @break
                        @case('room')
                          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                          @break
                        @case('reservation')
                          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                          @break
                        @case('payment')
                          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                          @break
                      @endswitch
                    </svg>
                    <h2 class="title-font font-medium text-3xl text-gray-900">{{ $item['count'] }}</h2>
                    <p class="leading-relaxed">{{ $item['label'] }}</p>
                  </div>
                </a>
              </div>
            @endforeach
          </div>
        </div>
      </section>
      <!-- Charts Section -->
      <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 px-4">
        <!-- Monthly Revenue Chart -->
        <div class="bg-white p-6 pb-6 rounded-lg shadow-xl">
            <h2 class="text-xl font-bold">Monthly Revenue</h2>
            <span class="text-sm font-semibold text-gray-500">{{ now()->year }}</span>
            <div class="flex items-end flex-grow w-full mt-2 space-x-2 sm:space-x-3">
                @php
                    $maxRevenue = $months->isNotEmpty() ? max($months->toArray()) : 1;
                    $maxHeight = 40;
                @endphp
                @foreach($months as $month => $revenue)
                    <div class="relative flex flex-col items-center flex-grow pb-5 group">
                        <span class="absolute top-0 hidden -mt-6 text-xs font-bold group-hover:block">₱{{ number_format($revenue) }}</span>
                        <div class="relative flex justify-center w-full h-{{ $maxRevenue > 0 ? round(($revenue / $maxRevenue) * $maxHeight) : 0 }} bg-indigo-400"></div>
                        <span class="absolute bottom-0 text-xs font-bold">{{ Carbon\Carbon::create()->month($month)->format('M') }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    
        <!-- Payment Collection Pie Chart -->
        <div class="bg-white p-6 pb-6 rounded-lg shadow-xl">
            <h2 class="text-xl font-bold">Payment Collection Status</h2>
            <span class="text-sm font-semibold text-gray-500">{{ now()->year }}</span>
            @php
                $paidCount = \App\Models\DueDate::where('status', 'paid')->count();
                $pendingCount = \App\Models\DueDate::where('status', 'pending')->count();
                $overdueCount = \App\Models\DueDate::where('status', '!=', 'paid')
                    ->where('payment_due_date', '<', \Carbon\Carbon::today())
                    ->count();
            @endphp
            <div class="w-full h-64">
                <canvas id="paymentChart"></canvas>
            </div>
        </div>
    
        <!-- Complaint Status Pie Chart -->
        <div class="bg-white p-6 pb-6 rounded-lg shadow-xl">
            <h2 class="text-xl font-bold">Complaint Status</h2>
            <span class="text-sm font-semibold text-gray-500">{{ now()->year }}</span>
            @php
                $openComplaints = \App\Models\Report::where('status', 'Pending')->count();
                $inProgressComplaints = \App\Models\Report::where('status', 'Ongoing')->count();
                $resolvedComplaints = \App\Models\Report::where('status', 'Fixed')->count();
            @endphp
            <div class="w-full h-64">
                <canvas id="complaintChart"></canvas>
            </div>
        </div>
    </section>
    
   <!-- Load Chart.js and Render Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
          renderCharts(); // Run on initial page load
      });

      document.addEventListener("turbolinks:load", function () {
          reloadCharts(); // Run when navigating with Turbolinks
      });

      function reloadCharts() {
          // Remove existing canvases and create new ones
          document.getElementById("paymentChart").remove();
          document.getElementById("complaintChart").remove();

          let paymentCanvas = document.createElement("canvas");
          paymentCanvas.id = "paymentChart";
          document.querySelector(".payment-chart-container").appendChild(paymentCanvas);

          let complaintCanvas = document.createElement("canvas");
          complaintCanvas.id = "complaintChart";
          document.querySelector(".complaint-chart-container").appendChild(complaintCanvas);

          setTimeout(renderCharts, 200); // Ensure DOM is ready before reloading charts
      }

      function renderCharts() {
          // Destroy existing charts if they exist
          Object.values(Chart.instances).forEach(instance => instance.destroy());

          // Payment Collection Chart
          const paymentCtx = document.getElementById("paymentChart").getContext("2d");
          new Chart(paymentCtx, {
              type: "pie",
              data: {
                  labels: ["Paid", "Overdue", "Pending"],
                  datasets: [{
                      data: [{{ $paidCount }}, {{ $overdueCount }}, {{ $pendingCount }}],
                      backgroundColor: ["#4CAF50", "#F44336", "#FFC107"],
                      hoverOffset: 5
                  }]
              },
              options: { responsive: true, maintainAspectRatio: false }
          });

          // Complaint Status Chart
          const complaintCtx = document.getElementById("complaintChart").getContext("2d");
          new Chart(complaintCtx, {
              type: "pie",
              data: {
                  labels: ["Open", "In Progress", "Resolved"],
                  datasets: [{
                      data: [{{ $openComplaints }}, {{ $inProgressComplaints }}, {{ $resolvedComplaints }}],
                      backgroundColor: ["#FF6384", "#FFCE56", "#36A2EB"],
                      hoverOffset: 5
                  }]
              },
              options: { responsive: true, maintainAspectRatio: false }
          });
      }
    </script>
</div>
