<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AP Portal</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 text-slate-900">

<div class="flex h-screen overflow-hidden">

    <!-- OVERLAY (mobile) -->
    <div id="overlay"
         class="fixed inset-0 bg-black/50 z-40 hidden md:hidden"></div>

    <!-- SIDEBAR -->
    <div id="sidebar"
         class="fixed inset-y-0 left-0 z-50 w-[80vw] max-w-[18rem] md:w-72 h-full
                bg-gradient-to-b from-red-700 to-red-900 text-white
                transform -translate-x-full md:translate-x-0
                transition-transform duration-300 flex flex-col justify-between shadow-xl">

        <div class="flex items-center justify-between px-4 py-4 md:hidden border-b border-white/20">
            <div class="text-white font-semibold">Menu</div>
            <button id="closeSidebarBtn" class="text-white text-2xl">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        @include('components.includes.sidebar')

    </div>

    <!-- MAIN AREA -->
    <div class="flex-1 flex flex-col overflow-hidden md:ml-72">

        <!-- MOBILE TOP BAR -->
        <div class="flex items-center justify-between bg-white shadow px-4 py-3 md:hidden">

            <button id="menuBtn" class="text-red-700 text-2xl">
                <i class="bi bi-list"></i>
            </button>

            <h1 class="font-bold text-red-700">AP Portal</h1>

        </div>

        <!-- DESKTOP HEADER -->
        <div class="hidden md:block">
            @include('components.includes.header')
        </div>

        <!-- CONTENT -->
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>

    </div>

</div>

<!-- JS ONLY (NO LIBRARIES) -->
<script>
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");
    const menuBtn = document.getElementById("menuBtn");

    function openSidebar() {
        sidebar.classList.remove("-translate-x-full");
        overlay.classList.remove("hidden");
    }

    function closeSidebar() {
        sidebar.classList.add("-translate-x-full");
        overlay.classList.add("hidden");
    }

    menuBtn.addEventListener("click", openSidebar);
    overlay.addEventListener("click", closeSidebar);

    const closeSidebarBtn = document.getElementById("closeSidebarBtn");
    if (closeSidebarBtn) {
        closeSidebarBtn.addEventListener("click", closeSidebar);
    }
</script>

</body>
</html>
