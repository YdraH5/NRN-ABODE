<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title class="no-print">@yield('title')</title>    
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
           <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <!-- Scrollbar Custom CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
        <style>
            
            #sidebar {
                scrollbar-width: none; /* Hide scrollbar for Firefox */
                -ms-overflow-style: none; /* Hide scrollbar for Internet Explorer/Edge */
            }

            #sidebar::-webkit-scrollbar {
                display: none; /* Hide scrollbar for Chrome, Safari, and Opera */
            }

            /* Hide in the web view */
            .print-only {
                display: none;
            }

            @media print {
        .print-container {
            display: flex !important;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .print-container .chart-container {
            width: 48% !important; /* Ensure equal width for both charts */
        }
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
            .overflow-x-auto {
            overflow: visible !important;
        }

        .print-only {
            display: block !important;
            text-align: center;
            padding: 20px;
            background: #fff !important;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .print-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .print-table th, .print-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .print-table th {
            background: #4f46e5 !important;
            color: white !important;
        }

        .no-print {
            display: none !important;
        }

        .bg-blue-100 { background-color: #bfdbfe !important; } 
        .bg-green-100 { background-color: #d1fae5 !important; } 
        .bg-yellow-100 { background-color: #fef3c7 !important; } 
        .bg-red-100 { background-color: #fee2e2 !important; } 

        body {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }

        </style>
    </head>
    <body class="bg-smokewhite">
       
           
        @include('components.layouts.navigation')
        <!-- Page Heading -->
 
        @if (isset($header))
            <header class="no-print bg-white shadow w-full">
                <div class="no-print max-w-full mx-8 py-2 px-12 ">
                    {{ $header }}
                </div>
            </header>
        @endif
        <!-- Page Content -->
            @yield('content')
            @livewireScripts
            
                <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function () {
        $("#sidebarCollapse").on('click', function () {
            $('#sidebar').toggleClass('active');
            $('#content').toggleClass('active');
            
            // Adjust button position when sidebar is toggled
            if ($('#sidebar').hasClass('active')) {
            $('#sidebarCollapse').css('left', '0'); // Adjust position when sidebar is hidden
            } else {
            $('#sidebarCollapse').css('left', '250px'); // Adjust position when sidebar is visible
            }
        });
        });
                document.getElementById('search-input').addEventListener('input', function(event) {
                    const searchValue = event.target.value;
                    const params = new URLSearchParams(window.location.search);
                    if (searchValue) {
                        params.set('search', searchValue);
                    } else {
                        params.delete('search');
                    }
                    const newUrl = `${window.location.pathname}?${params.toString()}`;
                    window.history.replaceState({}, '', newUrl);
                });
    </script> 
   
    </body>
</html>

