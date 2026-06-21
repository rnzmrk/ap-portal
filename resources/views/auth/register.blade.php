<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - AP Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-red-50 min-h-screen">

    <!-- Back Button -->
    <div class="p-4 sm:p-6">
        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 bg-white border border-red-200 px-4 py-2 rounded-lg shadow hover:bg-red-50 transition text-red-600 font-medium text-sm sm:text-base">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-4 h-4 sm:w-5 sm:h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 19l-7-7 7-7" />
            </svg>

            Back to Home
        </a>
    </div>

    <!-- Register Card -->
    <div class="flex justify-center px-4 pb-8">

        <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-6 sm:p-8 border border-red-100">

            <!-- Header -->
            <div class="text-center mb-6">
                <img src="{{ asset('images/megawide.png') }}"
                     class="w-32 sm:w-40 mx-auto mb-3">

                <h1 class="text-xl sm:text-2xl font-bold text-red-600">
                    Create Account
                </h1>

                <p class="text-sm text-slate-500">
                    Register to access AP Portal
                </p>
            </div>

            <!-- Errors -->
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 text-sm rounded border border-red-200">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Register Form -->
            <form action="{{ route('register.submit') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <label class="text-sm font-medium">Full Name</label>
                    <input type="text"
                           name="name"
                           class="w-full border border-red-200 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-red-400 focus:border-red-400"
                           required>
                </div>

                <!-- Email -->
                <div>
                    <label class="text-sm font-medium">Email</label>
                    <input type="email"
                           name="email"
                           class="w-full border border-red-200 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-red-400 focus:border-red-400"
                           required>
                </div>

                <!-- Password -->
                <div>
                    <label class="text-sm font-medium">Password</label>
                    <input type="password"
                           name="password"
                           class="w-full border border-red-200 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-red-400 focus:border-red-400"
                           required>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="text-sm font-medium">Confirm Password</label>
                    <input type="password"
                           name="password_confirmation"
                           class="w-full border border-red-200 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-red-400 focus:border-red-400"
                           required>
                </div>

                <!-- Register Button -->
                <button type="submit"
                        class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition">
                    Register
                </button>
            </form>

            <!-- Login Link -->
            <div class="text-center mt-4 text-sm">
                Already have an account?
                <a href="{{ route('login') }}"
                   class="text-red-600 font-medium hover:text-red-800">
                    Login
                </a>
            </div>

        </div>

    </div>

</body>
</html>
