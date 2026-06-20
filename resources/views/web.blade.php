<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AP Portal - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-red-50 text-slate-800">

<!-- NAVBAR -->
<header class="bg-white shadow-sm border-b border-red-100">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">

        <div class="flex items-center gap-3">
            <img src="{{ asset('images/megawide.png') }}" class="w-50 h-10">
            <span class="font-bold text-lg text-red-600">AP Portal</span>
        </div>

        <div class="space-x-3">
            <a href="{{ route('login') }}"
            class="px-4 py-2 text-sm font-medium text-red-600 hover:text-red-800">
                Login
            </a>

            <a href="{{ route('register') }}"
            class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700">
                Register
            </a>

            <a href="{{ route('register.employee') }}"
            class="px-4 py-2 bg-white border border-red-600 text-red-600 rounded-lg text-sm hover:bg-red-50">
                Employee Register
            </a>
        </div>

    </div>
</header>

<!-- HERO SECTION -->
<section class="max-w-6xl mx-auto px-6 py-20 text-center">

    <h1 class="text-4xl md:text-5xl font-bold mb-6">
        Welcome to <span class="text-red-600">AP Portal</span>
    </h1>

    <p class="text-lg text-slate-600 max-w-2xl mx-auto mb-8">
        A centralized system for Supplier, Procurement, Finance, and Operations.
        Manage PO-GPPO and Job Evaluation seamlessly in one platform.
    </p>

    <div class="flex justify-center gap-4">
        <a href="{{ route('login') }}"
           class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700">
            Get Started
        </a>

        <a href="#about"
           class="px-6 py-3 border border-red-200 text-red-600 rounded-lg hover:bg-red-50">
            Learn More
        </a>
    </div>

</section>

<!-- ABOUT SECTION -->
<section id="about" class="bg-white py-20 border-t border-red-100">

    <div class="max-w-6xl mx-auto px-6 text-center">

        <h2 class="text-3xl font-bold mb-6 text-red-600">About Us</h2>

        <p class="text-slate-600 max-w-3xl mx-auto leading-relaxed">
            AP Portal is designed to streamline procurement workflows between suppliers,
            procurement officers, finance teams, and operations. It provides a centralized
            and secure platform for managing purchase orders, evaluations, and approvals.
        </p>

    </div>

</section>

<!-- FEATURES SECTION -->
<section class="py-20 bg-red-50">

    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded-xl shadow border border-red-100">
            <h3 class="font-bold text-lg mb-2 text-red-600">Supplier Management</h3>
            <p class="text-slate-600 text-sm">
                Submit PO-GPPO and track job evaluations easily.
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow border border-red-100">
            <h3 class="font-bold text-lg mb-2 text-red-600">Procurement Control</h3>
            <p class="text-slate-600 text-sm">
                Review and approve supplier submissions efficiently.
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow border border-red-100">
            <h3 class="font-bold text-lg mb-2 text-red-600">Finance & Operations</h3>
            <p class="text-slate-600 text-sm">
                Ensure compliance and financial accuracy across processes.
            </p>
        </div>

    </div>

</section>

<!-- CONTACT SECTION -->
<section id="contact" class="bg-white py-20 border-t border-red-100">

    <div class="max-w-6xl mx-auto px-6 text-center">

        <h2 class="text-3xl font-bold mb-6 text-red-600">Contact Us</h2>

        <p class="text-slate-600 mb-8">
            Have questions? Reach out to our support team.
        </p>

        <div class="max-w-md mx-auto text-left space-y-4">

            <input type="text" placeholder="Your Name"
                   class="w-full border border-red-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-300">

            <input type="email" placeholder="Your Email"
                   class="w-full border border-red-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-300">

            <textarea placeholder="Your Message"
                      class="w-full border border-red-200 rounded-lg px-4 py-2 h-32 focus:ring-2 focus:ring-red-300"></textarea>

            <button class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700">
                Send Message
            </button>

        </div>

    </div>

</section>

<!-- FOOTER -->
<footer class="bg-red-900 text-white py-6 text-center text-sm">
    © {{ date('Y') }} AP Portal. All rights reserved.
</footer>

</body>
</html>
