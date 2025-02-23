<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{
    darkMode: localStorage.getItem('darkMode') || 'system',
    updateDarkMode() {
        if (this.darkMode === 'dark') {
            document.documentElement.classList.add('dark');
        } else if (this.darkMode === 'light') {
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.toggle(
                'dark',
                window.matchMedia('(prefers-color-scheme: dark)').matches
            );
        }
    },
    isSidebarOpen: window.innerWidth > 900, // Initialize sidebar state based on screen size
    updateSidebarState() {
        this.isSidebarOpen = window.innerWidth > 900;
    }
}" x-init="updateDarkMode();
$watch('darkMode', value => {
    localStorage.setItem('darkMode', value);
    updateDarkMode();
});
window.addEventListener('resize', updateSidebarState);"
    :class="{
        'dark': darkMode === 'dark' || (darkMode === 'system' && window.matchMedia('(prefers-color-scheme: dark)')
            .matches)
    }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans bg-gray-50 dark:bg-gray-700 antialiased">
    <div>
        <x-layout.navbar />
        <x-layout.sidebar />
        <div x-data>
            <main
                :class="{ 'ml-0': !$store.sidebar.isSidebarOpen, 'lg:ml-64 md:ml-0 sm:ml-0': $store.sidebar.isSidebarOpen }"
                class="p-4 h-auto pt-20 transition-all duration-300 ease-in-out ">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('modals')
    @livewireScripts
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('sidebar', {
                isSidebarOpen: window.innerWidth > 900,
                toggle() {
                    this.isSidebarOpen = !this.isSidebarOpen;
                    localStorage.setItem('isSidebarOpen', this
                        .isSidebarOpen); // Store sidebar state in localStorage
                },
                close() {
                    this.isSidebarOpen = false;
                    localStorage.setItem('isSidebarOpen', false); // Store sidebar state in localStorage
                },
                open() {
                    this.isSidebarOpen = true;
                    localStorage.setItem('isSidebarOpen', true); // Store sidebar state in localStorage
                },
                init() {
                    // Update sidebar state on window resize and load from localStorage
                    this.isSidebarOpen = JSON.parse(localStorage.getItem('isSidebarOpen')) || window
                        .innerWidth > 900;
                    window.addEventListener('resize', () => {
                        this.isSidebarOpen = window.innerWidth > 900;
                    });
                }
            });
        });
    </script>
</body>

</html>
