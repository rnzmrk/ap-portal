@extends('components.app')

@section('title', 'Finance Dashboard')

@section('content')

<div class="space-y-6">

    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-slate-800">
            Finance Dashboard
        </h1>
        <p class="text-slate-500">
            Overview of JO Evaluation and PO GPPO records.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div class="bg-white border border-slate-200 rounded-lg p-4">
            <p class="text-xs uppercase tracking-wide text-slate-500">
                Total JO Amount
            </p>

            <h2 class="mt-2 text-2xl font-bold text-blue-600">
                ₱{{ number_format($totalJoAmount, 2) }}
            </h2>
        </div>

        <div class="bg-white border border-slate-200 rounded-lg p-4">
            <p class="text-xs uppercase tracking-wide text-slate-500">
                Total PO Amount
            </p>

            <h2 class="mt-2 text-2xl font-bold text-green-600">
                ₱{{ number_format($totalPoAmount, 2) }}
            </h2>
        </div>

    </div>

    <!-- JO Statistics -->
    <div>
        <h2 class="text-lg font-semibold text-slate-800 mb-3">
            JO Evaluation Summary
        </h2>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">

            <div class="bg-white rounded-lg border border-slate-200 p-4">
                <p class="text-xs uppercase tracking-wide text-slate-500">
                    All JO
                </p>
                <h3 class="mt-2 text-2xl font-bold text-slate-800">
                    {{ $allJo }}
                </h3>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <p class="text-xs uppercase tracking-wide text-yellow-700">
                    Pending
                </p>
                <h3 class="mt-2 text-2xl font-bold text-yellow-600">
                    {{ $pendingJo }}
                </h3>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <p class="text-xs uppercase tracking-wide text-green-700">
                    Approved
                </p>
                <h3 class="mt-2 text-2xl font-bold text-green-600">
                    {{ $approvedJo }}
                </h3>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-xs uppercase tracking-wide text-blue-700">
                    Released
                </p>
                <h3 class="mt-2 text-2xl font-bold text-blue-600">
                    {{ $releasedJo }}
                </h3>
            </div>

            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <p class="text-xs uppercase tracking-wide text-red-700">
                    Rejected
                </p>
                <h3 class="mt-2 text-2xl font-bold text-red-600">
                    {{ $rejectedJo }}
                </h3>
            </div>

        </div>
    </div>


    <!-- PO Statistics -->
    <div>
        <h2 class="text-lg font-semibold text-slate-800 mb-3">
            PO GPPO Summary
        </h2>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">

            <div class="bg-white rounded-lg border border-slate-200 p-4">
                <p class="text-xs uppercase tracking-wide text-slate-500">
                    All PO
                </p>
                <h3 class="mt-2 text-2xl font-bold text-slate-800">
                    {{ $allPo }}
                </h3>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <p class="text-xs uppercase tracking-wide text-yellow-700">
                    Pending
                </p>
                <h3 class="mt-2 text-2xl font-bold text-yellow-600">
                    {{ $pendingPo }}
                </h3>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <p class="text-xs uppercase tracking-wide text-green-700">
                    Approved
                </p>
                <h3 class="mt-2 text-2xl font-bold text-green-600">
                    {{ $approvedPo }}
                </h3>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-xs uppercase tracking-wide text-blue-700">
                    Released
                </p>
                <h3 class="mt-2 text-2xl font-bold text-blue-600">
                    {{ $releasedPo }}
                </h3>
            </div>

            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <p class="text-xs uppercase tracking-wide text-red-700">
                    Returned
                </p>
                <h3 class="mt-2 text-2xl font-bold text-red-600">
                    {{ $returnedPo }}
                </h3>
            </div>

        </div>
    </div>

    <!----charts---->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-6">

<!-- JO Monthly -->
<div class="bg-white rounded-xl shadow p-5 w-full">
    <h2 class="text-sm sm:text-base font-semibold text-slate-800 mb-4">
        JO Amount Per Month
    </h2>
    <div class="h-64 sm:h-72">
        <canvas id="joMonthlyChart"></canvas>
    </div>
</div>

<!-- PO Monthly -->
<div class="bg-white rounded-xl shadow p-5 w-full">
    <h2 class="text-sm sm:text-base font-semibold text-slate-800 mb-4">
        PO Amount Per Month
    </h2>
    <div class="h-64 sm:h-72">
        <canvas id="poMonthlyChart"></canvas>
    </div>
</div>

<!-- PO Status -->
<div class="bg-white rounded-xl shadow p-5 w-full">
    <h2 class="text-sm sm:text-base font-semibold text-slate-800 mb-4">
        PO Status Summary
    </h2>
    <div class="h-64 sm:h-72">
        <canvas id="poStatusChart"></canvas>
    </div>
</div>

<!-- JO Status -->
<div class="bg-white rounded-xl shadow p-5 w-full">
    <h2 class="text-sm sm:text-base font-semibold text-slate-800 mb-4">
        JO Status Summary
    </h2>
    <div class="h-64 sm:h-72">
        <canvas id="joStatusChart"></canvas>
    </div>
</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

// Month labels (Jan–Dec)
const months = [
    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
];

// Convert Laravel data safely
const joMonthly = @json($joMonthly);
const poMonthly = @json($poMonthly);

// Fill missing months with 0
function mapMonths(data) {
    let result = [];
    for (let i = 1; i <= 12; i++) {
        result.push(data[i] ?? 0);
    }
    return result;
}

// JO Monthly Chart
new Chart(document.getElementById('joMonthlyChart'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'JO Amount',
            data: mapMonths(joMonthly),
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,0.2)',
            fill: true,
            tension: 0.4
        }]
    }
});

// PO Monthly Chart
new Chart(document.getElementById('poMonthlyChart'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'PO Amount',
            data: mapMonths(poMonthly),
            borderColor: '#10b981',
            backgroundColor: 'rgba(16,185,129,0.2)',
            fill: true,
            tension: 0.4
        }]
    }
});

// PO Status Chart
new Chart(document.getElementById('poStatusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Approved', 'Released', 'Returned'],
        datasets: [{
            data: [
                {{ $pendingPo }},
                {{ $approvedPo }},
                {{ $releasedPo }},
                {{ $returnedPo }}
            ],
            backgroundColor: [
                '#facc15',
                '#22c55e',
                '#3b82f6',
                '#ef4444'
            ]
        }]
    }
});

new Chart(document.getElementById('joStatusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Approved', 'Released', 'Rejected'],
        datasets: [{
            data: [
                {{ $pendingJo }},
                {{ $approvedJo }},
                {{ $releasedJo }},
                {{ $rejectedJo }}
            ],
            backgroundColor: [
                '#facc15',
                '#22c55e',
                '#3b82f6',
                '#ef4444'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

</script>
@endsection