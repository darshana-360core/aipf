<!DOCTYPE html>
<html lang="en">

<head>
    
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-2VC3M7G9W5"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-2VC3M7G9W5');
</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'OrbitX') | OrbitX – The Future of AI</title>
    <link rel="icon" href={{ asset('assets/images/favico.ico') }}>

    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'OrbitX') | OrbitX – The Future of AI">
    <meta property="og:description" content="@yield('og_description', 'OrbitX is shaping the future with AI-powered innovations and blockchain technology.')">
    <meta property="og:image" content="@yield('og_image', asset('assets/images/orbitx-logo.png'))">
    <meta property="og:url" content="{{ url()->current() }}">


    <!-- Tailwind CDN -->
    <script src="{{asset('assets/js/tailwindcss-3.4.16.js')}}"></script>
    <!-- Notyf (Toaster Library) -->
    <link rel="stylesheet" href="{{asset('assets/css/notyf.min.css')}}">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href={{ asset('assets/css/styles.css') }}?v={{time()}}>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <style>
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #2b2b2f;
            background-color: #0f0f0f;
            padding: 2px 5px;
            outline: none;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #2b2b2f;
            border-radius: 3px;
            padding: 5px 10px;
            background-color: transparent;
            margin-left: 3px;
            outline: none;
        }
    </style>
    @yield(section: 'style')
</head>

<body class="bg-[#0f0f1c] text-white">
    @if (!Request::is('login') && !Request::is('register') && !Request::is('404') && !Request::is('500') && !Request::is('forgot-password') && !Request::is('connect-wallet'))
    <!-- Main Content -->
    <div class="wrapper h-screen overflow-hidden">
        <main class="flex flex-wrap lg:flex-nowrap overflow-auto" style="height: calc(0px + 100vh);">
            @include('components.sidemenu')
            <div class="relative flex-1 max-w-screen-2xl mx-auto p-1 lg:px-5 lg:py-px lg:pl-0 w-full">
                <div class="bg-[#0f0f1c] border border-[#322751] p-3 md:p-5 pt-0 md:pt-0 rounded-0 h-auto min-h-[99.8vh]">
                     <!-- overflow-auto -->
                    <div id="page-loader" class="absolute top-0 left-0 w-full h-full flex items-center justify-center bg-[#0f0f1c] bg-opacity-1 backdrop-blur-md z-50">
                        <img src={{ asset('assets/images/logo.webp') }} alt="Loader" width="96" height="96" class="h-16 w-16 mb-24 object-contain">
                    </div>
                    @include('components.header')
                    @yield(section: 'content')
                    @include('components.footer')
                </div>
            </div>
        </main>
    </div>
    @else
    <!-- Single Page -->
    <div class="wrapper h-screen overflow-hidden">
        <main class="flex p-0">
            <div class="w-full overflow-auto relative" style="height: calc(100vh);">
                <div id="page-loader" class="absolute top-0 left-0 w-full h-full flex items-center justify-center bg-[#0f0f1c] bg-opacity-1 backdrop-blur-md z-50">
                    <img src={{ asset('assets/images/logo.webp') }} alt="Loader" width="96" height="96" class="h-16 w-16 mb-24 object-contain">
                </div>
                @yield(section: 'content')
                @include('components.footer')
            </div>
        </main>
    </div>
    @endif

    <!-- Data Table Js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <!-- Notyf JS -->
    <script src="{{asset('assets/js/flowbite.min.js')}}"></script>
    <script src="{{asset('assets/js/notyf.min.js')}}"></script>
    <script src="{{asset('assets/js/dialog.js')}}"></script>
    <script src="{{asset('assets/js/alpinejs-cdn.min.js')}}" defer></script>
    <script src="{{asset('assets/js/custom.js')}}?v={{time()}}"></script>
    <script>
        var notyf = new Notyf({
            duration: 3000, // Auto-close after 3s
            dismissible: true,
            position: {
                x: 'right',
                y: 'top'
            },
            ripple: false, // Prevent overlapping animations
            types: [{
                    type: 'success',
                    background: 'green',
                },
                {
                    type: 'error',
                    background: 'red',
                },
                {
                    type: 'warning',
                    background: 'orange',
                },
                {
                    type: 'info',
                    background: 'blue',
                }
            ]
        });
        var notyfNotifications = [];

        function showToast(type, message) {
            let input = message || configuration;
            let notification;
            // if message is non null then call notyf with the message
            // otherwise open the notyf with the config object
            if (type === 'success') {
                notification = notyf.success(input);
            } else if (type === 'error') {
                notification = notyf.error(input);
            } else {
                const opts = Object.assign({}, {
                    type
                }, {
                    message: input
                });
                notification = notyf.open(opts);
            }
            notyfNotifications.push(notification);
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggles = document.querySelectorAll(".submenu-toggle");

            toggles.forEach(toggle => {
                toggle.addEventListener("click", function() {
                    const submenu = this.nextElementSibling;

                    // Hide other submenus
                    document.querySelectorAll(".submenu").forEach(sub => {
                        if (sub !== submenu) {
                            sub.classList.add("hidden");
                            sub.previousElementSibling.classList.remove("activemenu");
                            sub.previousElementSibling.querySelector(".arrow").classList.remove("rotate-180");
                        }
                    });

                    // Toggle the clicked submenu
                    submenu.classList.toggle("hidden");
                    this.classList.toggle("activemenu");

                    // Rotate arrow indicator
                    const arrow = this.querySelector(".arrow");
                    arrow.classList.toggle("rotate-180");
                });
            });

            // Keep submenu open if a submenu link is active
            document.querySelectorAll(".activesub").forEach(activeItem => {
                let submenu = activeItem.closest(".submenu");
                if (submenu) {
                    submenu.classList.remove("hidden");
                    submenu.previousElementSibling.classList.add("activemenu");
                    submenu.previousElementSibling.querySelector(".arrow").classList.add("rotate-180");
                }
            });

            // Loader Hide Show js
            setTimeout(function() {
                let loader = document.getElementById("page-loader");
                if (loader) {
                    loader.style.display = "none";
                }
            }, 0);
        });
    </script>

    @if ($sessionData = Session::get('data'))
    @if($sessionData['status_code'] == 1)
    <script type="text/javascript">
        showToast("success", "{{ $sessionData['message'] }}");
    </script>
    @else
    <script type="text/javascript">
        showToast("error", "{{ $sessionData['message'] }}");
    </script>
    @endif
    @endif
    @yield(section: 'script')
</body>

</html>