<header class="sticky top-0 z-40 h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between">

    <!-- Left Side -->
    <div>

    </div>

    <!-- Right Side -->
    <div class="relative">

        <button
            type="button"
            id="user-menu-button"
            class="flex items-center gap-3 rounded-lg px-3 py-2 hover:bg-slate-100 transition">

            <div class="text-right">
                <div class="text-sm font-medium text-slate-800">
                    {{ auth()->user()->name }}
                </div>

                <div class="text-xs text-slate-500 capitalize">
                    {{ auth()->user()->role }}
                </div>
            </div>

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-4 w-4 text-slate-500"
                 fill="none"
                 viewBox="0 0 24 24">
                <path d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                      stroke="currentColor"
                      stroke-width="1.5"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>

        </button>

        <!-- Dropdown -->
        <div
            id="user-dropdown"
            class="hidden absolute right-0 mt-3 w-72 bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">

            <!-- User Info -->
            <div class="p-4 border-b">

                <h4 class="font-semibold text-slate-800">
                    {{ auth()->user()->name }}
                </h4>

                <p class="text-sm text-slate-500">
                    {{ auth()->user()->email }}
                </p>

                <span class="text-xs text-slate-400 capitalize">
                    {{ auth()->user()->role }}
                </span>

            </div>

            <!-- Logout Only -->
            <div class="py-2">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5"
                             fill="none"
                             viewBox="0 0 24 24">

                            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"
                                  stroke="currentColor"
                                  stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>

                            <polyline points="16,17 21,12 16,7"
                                      stroke="currentColor"
                                      stroke-width="1.5"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"/>

                            <line x1="21"
                                  y1="12"
                                  x2="9"
                                  y2="12"
                                  stroke="currentColor"
                                  stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>

                        </svg>

                        Logout

                    </button>

                </form>

            </div>

        </div>

    </div>

</header>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const userMenuButton = document.getElementById('user-menu-button');
    const userDropdown = document.getElementById('user-dropdown');

    userMenuButton.addEventListener('click', function (e) {
        e.stopPropagation();
        userDropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', function () {
        userDropdown.classList.add('hidden');
    });

    userDropdown.addEventListener('click', function (e) {
        e.stopPropagation();
    });

});
</script>
