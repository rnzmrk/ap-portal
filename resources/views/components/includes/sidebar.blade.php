@php
    $role = auth()->user()->role;
    $user = auth()->user();
@endphp

<!-- TOP -->
<div>

    <!-- LOGO -->
    <div class="flex items-center gap-3 px-5 py-5 border-b border-red-500/40">
        <div class="w-10 h-10 bg-white text-red-700 font-bold flex items-center justify-center rounded-lg">
            AP
        </div>

        <div>
            <h1 class="font-bold text-lg">AP Portal</h1>
            <p class="text-xs text-red-200">Management System</p>
        </div>
    </div>

    <!-- NAV -->
    <nav class="mt-5 space-y-1 px-3">

        <!-- Dashboard -->
        <a href="{{ route($role . '.dashboard') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-lg transition
           {{ request()->routeIs($role.'.dashboard')
                ? 'bg-white text-red-700 font-semibold'
                : 'hover:bg-red-600/60' }}">

            <i class="bi bi-house-door-fill"></i>
            <span>Dashboard</span>
        </a>

        <!-- PO-GPPO -->
        <a href="{{ route($role . '.po-gppo.index') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-lg transition
           {{ request()->routeIs($role.'.po-gppo.*')
                ? 'bg-white text-red-700 font-semibold'
                : 'hover:bg-red-600/60' }}">

            <i class="bi bi-file-earmark-text-fill"></i>
            <span>PO-GPPO</span>
        </a>

        <!-- JO Evaluation -->
        <a href="{{ route($role . '.jo-evaluation.index') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-lg transition
           {{ request()->routeIs($role.'.jo-evaluation.*')
                ? 'bg-white text-red-700 font-semibold'
                : 'hover:bg-red-600/60' }}">

            <i class="bi bi-bar-chart-fill"></i>
            <span>JO Evaluation</span>
        </a>

    </nav>
</div>

<!-- BOTTOM -->
<div class="px-4 py-4 border-t border-red-500/40">

    <!-- USER -->
    <div class="mb-3">
        <p class="font-semibold text-sm">{{ $user->name }}</p>
        <p class="text-xs text-red-200 capitalize">{{ $user->role }}</p>
    </div>

    <!-- LOGOUT -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="w-full bg-white text-red-700 py-2 rounded-lg font-semibold hover:bg-red-100 flex items-center justify-center gap-2">
            <i class="bi bi-box-arrow-right"></i>
            Logout
        </button>
    </form>

</div>
