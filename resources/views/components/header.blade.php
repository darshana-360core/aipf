<header class="w-full z-[51] sticky top-0 bg-[#0f0f1c]">
    <div class="px-5 -mx-5 py-3 overflow-auto border-b border-[#322751]">
        <div class="flex justify-between items-center max-w-[1920px]">
            <div class="flex items-center justify-center">
                <!-- <p class="hidden lg:block">Welcome to {{ Request::is('/') ? 'Dashboard' : ucwords(str_replace('-', ' ', Request::segment(1))) }}!</p> -->
                <p class="hidden lg:block">Welcome to Orbitx!</p>
                <a class="py-0 lg:hidden" href="/">
                    <img src={{ asset('assets/images/logo.webp') }} alt="Logo" width="150" height="100" class="w-10 h-auto">
                </a>
            </div>
            <div class="flex items-center gap-2">
                <div class="relative flex items-center gap-1 sm:gap-3">
                    <!-- <button 
                        type="button" 
                        class="text-white text-sm sm:text-base flex items-center gap-2 font-normal capitalize border-opacity-50 rounded-md px-2 sm:px-3 py-2 bg-gradient-to-t from-[#6b3fb9] to-indigo-500 border border-[#bd97ff] pointer-events-none">
                       <span>$1.51</span>
                    </button> -->
                     <button onclick="window.location.reload()" class="text-white text-sm sm:text-base flex items-center gap-1 sm:gap-2 font-normal capitalize border-opacity-50 rounded-md px-2 sm:px-3 py-2 active bg-gradient-to-t from-[#6b3fb9] to-indigo-500 border border-[#bd97ff] hover:from-[#7c4bc7] hover:to-indigo-600 transition-all duration-200">
                        <!-- Realod -->
                        <svg class="w-4 h-5 ml-px sm:w-6 sm:h-6 transform transition-transform duration-200" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <rect width="24" height="24"></rect> <path d="M21.3687 13.5827C21.4144 13.3104 21.2306 13.0526 20.9583 13.0069C20.686 12.9612 20.4281 13.1449 20.3825 13.4173L21.3687 13.5827ZM12 20.5C7.30558 20.5 3.5 16.6944 3.5 12H2.5C2.5 17.2467 6.75329 21.5 12 21.5V20.5ZM3.5 12C3.5 7.30558 7.30558 3.5 12 3.5V2.5C6.75329 2.5 2.5 6.75329 2.5 12H3.5ZM12 3.5C15.3367 3.5 18.2252 5.4225 19.6167 8.22252L20.5122 7.77748C18.9583 4.65062 15.7308 2.5 12 2.5V3.5ZM20.3825 13.4173C19.7081 17.437 16.2112 20.5 12 20.5V21.5C16.7077 21.5 20.6148 18.0762 21.3687 13.5827L20.3825 13.4173Z" fill="#ffffff"></path> <path d="M20.4716 2.42157V8.07843H14.8147" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </button>
                    <button 
                        id="userMenuToggle"
                        type="button" 
                        class="text-white text-sm sm:text-base flex items-center gap-1 sm:gap-2 font-normal capitalize border-opacity-50 rounded-md px-2 sm:px-3 py-2 active bg-gradient-to-t from-[#6b3fb9] to-indigo-500 border border-[#bd97ff] hover:from-[#7c4bc7] hover:to-indigo-600 transition-all duration-200">
                        {{ substr(Session::get('wallet_address'), 0, 6) }}...{{ substr(Session::get('wallet_address'), -6) }}
                        <svg class="w-3 h-3 ml-px sm:w-4 sm:h-4 sm:ml-1 transform transition-transform duration-200" id="userMenuIcon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <button class="flex lg:hidden flex-col items-center h-auto text-white space-y-2 text-sm bg-white/0 pl-1 sm:pl-5 pr-0 sm:pr-2 py-2" onclick="toggleSidebar()">
                    <svg width="24" height="24" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="22" y="11" width="4" height="4" rx="2" fill="#ffffff"></rect>
                        <rect x="11" width="4" height="4" rx="2" fill="#ffffff"></rect>
                        <rect x="22" width="4" height="4" rx="2" fill="#32a7e2"></rect>
                        <rect x="11" y="11" width="4" height="4" rx="2" fill="#32a7e2"></rect>
                        <rect x="11" y="22" width="4" height="4" rx="2" fill="#ffffff"></rect>
                        <rect width="4" height="4" rx="2" fill="#ffffff"></rect>
                        <rect y="11" width="4" height="4" rx="2" fill="#ffffff"></rect>
                        <rect x="22" y="22" width="4" height="4" rx="2" fill="#ffffff"></rect>
                        <rect y="22" width="4" height="4" rx="2" fill="#32a7e2"></rect>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('sidemenutoggle');
        }
    </script>
</header>

<!-- Floating User Menu Dropdown -->
<div id="userMenuDropdown" class="absolute top-16 !right-10 bg-white shadow-2xl rounded-lg border border-gray-200 min-w-[120px] z-[100] opacity-0 invisible transform scale-95 transition-all duration-200 ease-out">
    <!-- Menu Items -->
    <div class="py-2">
        <!-- Logout Button -->
        <a 
            href="{{ route('flogout') }}" 
            class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-150"
        >
            <svg class="w-4 h-4 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            Disconnect
        </a>
    </div>
</div>

<!-- Overlay for mobile/tablet -->
<div id="userMenuOverlay" class="fixed inset-0 z-[99] bg-black bg-opacity-25 opacity-0 invisible transition-opacity duration-200"></div>

<!-- JavaScript for User Menu -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('userMenuToggle');
        const menuDropdown = document.getElementById('userMenuDropdown');
        const menuOverlay = document.getElementById('userMenuOverlay');
        const menuIcon = document.getElementById('userMenuIcon');
        let isMenuOpen = false;

        function openMenu() {
            isMenuOpen = true;
            menuDropdown.classList.remove('opacity-0', 'invisible', 'scale-95');
            menuDropdown.classList.add('opacity-100', 'visible', 'scale-100');
            menuOverlay.classList.remove('opacity-0', 'invisible');
            menuOverlay.classList.add('opacity-100', 'visible');
            menuIcon.classList.add('rotate-180');
            
            // Position the dropdown relative to the button
            const rect = menuToggle.getBoundingClientRect();
            const dropdown = menuDropdown;
            const viewportWidth = window.innerWidth;
            
            // Ensure dropdown doesn't go off-screen
            if (rect.right + 120 > viewportWidth) {
                dropdown.style.right = '5px';
                dropdown.style.left = 'auto';
            } else {
                dropdown.style.left = rect.left + 'px';
                dropdown.style.right = 'auto';
            }
        }

        function closeMenu() {
            isMenuOpen = false;
            menuDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
            menuDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
            menuOverlay.classList.remove('opacity-100', 'visible');
            menuOverlay.classList.add('opacity-0', 'invisible');
            menuIcon.classList.remove('rotate-180');
        }

        // Toggle menu on button click
        menuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            if (isMenuOpen) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        // Close menu when clicking overlay
        menuOverlay.addEventListener('click', closeMenu);

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (isMenuOpen && !menuDropdown.contains(e.target) && !menuToggle.contains(e.target)) {
                closeMenu();
            }
        });

        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isMenuOpen) {
                closeMenu();
            }
        });

        // Handle responsive positioning
        window.addEventListener('resize', function() {
            if (isMenuOpen) {
                const rect = menuToggle.getBoundingClientRect();
                const dropdown = menuDropdown;
                const viewportWidth = window.innerWidth;
                
                if (rect.right + 120 > viewportWidth) {
                    dropdown.style.right = '5px';
                    dropdown.style.left = 'auto';
                } else {
                    dropdown.style.left = rect.left + 'px';
                    dropdown.style.right = 'auto';
                }
            }
        });
    });
</script>

<style>
    /* Additional styles for better visual hierarchy */
    #userMenuDropdown {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        backdrop-filter: blur(8px);
    }

    /* Smooth transitions */
    #userMenuToggle {
        transition: all 0.2s ease;
    }
    
    #userMenuToggle:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(107, 63, 185, 0.3);
    }
</style>