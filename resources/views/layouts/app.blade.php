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
    }
}" x-init="updateDarkMode();
$watch('darkMode', value => {
    localStorage.setItem('darkMode', value);
    updateDarkMode();
})"
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

<body class="font-sans antialiased">

 <div>
    <x-layout.navbar/>
    <x-layout.sidebar/>
    <main>
        {{ $slot }}
    </main>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('sidebar', {
            isSidebarOpen: true
        });
        Alpine.store('darkMode', {
            value: localStorage.getItem('darkMode') === 'true',
            toggle() {
                this.value = !this.value;
                localStorage.setItem('darkMode', this.value);
            },
            init() {
                this.value = localStorage.getItem('darkMode') === 'true';
            }
        });
    });
</script>


    
    @stack('modals')
    @livewireScripts
</body>

</html>
