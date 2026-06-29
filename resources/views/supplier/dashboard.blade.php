@extends('components.app')

@section('title', 'Supplier Dashboard')

@section('content')

<div class="space-y-4">

    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-slate-800">
            Supplier Dashboard
        </h1>
        <p class="text-slate-500 text-sm">
            Overview of your Purchase Orders and Job Orders.
        </p>
    </div>

    <!-- Amount Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">

        <div class="bg-white border border-slate-200 rounded-md p-2">
            <p class="text-[10px] text-slate-500 uppercase tracking-wide leading-none">
                Pending Invoice JO
            </p>
            <h2 class="mt-0.5 text-base font-semibold text-slate-800">
                ₱{{ number_format($pendingJoAmount, 2) }}
            </h2>
        </div>

        <div class="bg-white border border-slate-200 rounded-md p-2">
            <p class="text-[10px] text-slate-500 uppercase tracking-wide leading-none">
                Pending Invoice PO
            </p>
            <h2 class="mt-0.5 text-base font-semibold text-slate-800">
                ₱{{ number_format($pendingPoAmount, 2) }}
            </h2>
        </div>

        <div class="bg-white border border-slate-200 rounded-md p-2">
            <p class="text-[10px] text-slate-500 uppercase tracking-wide leading-none">
                Paid JO
            </p>
            <h2 class="mt-0.5 text-base font-semibold text-slate-800">
                ₱{{ number_format($releasedJoAmount, 2) }}
            </h2>
        </div>

        <div class="bg-white border border-slate-200 rounded-md p-2">
            <p class="text-[10px] text-slate-500 uppercase tracking-wide leading-none">
                Paid PO
            </p>
            <h2 class="mt-0.5 text-base font-semibold text-slate-800">
                ₱{{ number_format($releasedPoAmount, 2) }}
            </h2>
        </div>

    </div>

    <!-- JO SUMMARY -->
    <div>
        <h2 class="text-base font-semibold text-slate-800 mb-2">
            Job Order Summary
        </h2>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-2">

            <div class="bg-white border border-slate-200 rounded-md p-2">
                <p class="text-[11px] text-slate-500">All JO</p>
                <h3 class="text-lg font-semibold text-slate-800">
                    {{ $allJo }}
                </h3>
            </div>

            <div class="bg-white border border-slate-200 rounded-md p-2">
                <p class="text-[11px] text-slate-500">Pending</p>
                <h3 class="text-lg font-semibold text-slate-800">
                    {{ $pendingJo }}
                </h3>
            </div>

            <div class="bg-white border border-slate-200 rounded-md p-2">
                <p class="text-[11px] text-slate-500">Approved</p>
                <h3 class="text-lg font-semibold text-slate-800">
                    {{ $approvedJo }}
                </h3>
            </div>

            <div class="bg-white border border-slate-200 rounded-md p-2">
                <p class="text-[11px] text-slate-500">Paid</p>
                <h3 class="text-lg font-semibold text-slate-800">
                    {{ $releasedJo }}
                </h3>
            </div>

            <div class="bg-white border border-slate-200 rounded-md p-2">
                <p class="text-[11px] text-slate-500">Rejected</p>
                <h3 class="text-lg font-semibold text-slate-800">
                    {{ $rejectedJo }}
                </h3>
            </div>

        </div>
    </div>

    <!-- PO SUMMARY -->
    <div>
        <h2 class="text-base font-semibold text-slate-800 mb-2">
            Purchase Order Summary
        </h2>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-2">

            <div class="bg-white border border-slate-200 rounded-md p-2">
                <p class="text-[11px] text-slate-500">All PO</p>
                <h3 class="text-lg font-semibold text-slate-800">
                    {{ $allPo }}
                </h3>
            </div>

            <div class="bg-white border border-slate-200 rounded-md p-2">
                <p class="text-[11px] text-slate-500">Pending</p>
                <h3 class="text-lg font-semibold text-slate-800">
                    {{ $pendingPo }}
                </h3>
            </div>

            <div class="bg-white border border-slate-200 rounded-md p-2">
                <p class="text-[11px] text-slate-500">Approved</p>
                <h3 class="text-lg font-semibold text-slate-800">
                    {{ $approvedPo }}
                </h3>
            </div>

            <div class="bg-white border border-slate-200 rounded-md sp-2">
                <p class="text-[11px] text-slate-500">Paid</p>
                <h3 class="text-lg font-semibold text-slate-800">
                    {{ $releasedPo }}
                </h3>
            </div>

            <div class="bg-white border border-slate-200 rounded-md p-2">
                <p class="text-[11px] text-slate-500">Rejected</p>
                <h3 class="text-lg font-semibold text-slate-800">
                    {{ $returnedPo }}
                </h3>
            </div>

        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">

        <div class="bg-white rounded-lg border border-slate-200 p-4">
            <h2 class="text-sm font-semibold text-slate-800 mb-2">
                JO Amount Per Month
            </h2>
            <div class="h-64">
                <canvas id="joMonthlyChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 p-4">
            <h2 class="text-sm font-semibold text-slate-800 mb-2">
                PO Amount Per Month
            </h2>
            <div class="h-64">
                <canvas id="poMonthlyChart"></canvas>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

const joMonthly = @json($joMonthly);
const poMonthly = @json($poMonthly);

function mapMonths(data) {
    let result = [];
    for (let i = 1; i <= 12; i++) {
        result.push(data[i] ?? 0);
    }
    return result;
}

new Chart(document.getElementById('joMonthlyChart'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'JO Amount',
            data: mapMonths(joMonthly),
            borderColor: '#64748b',
            backgroundColor: 'rgba(100,116,139,0.15)',
            fill: true,
            tension: 0.4
        }]
    }
});

new Chart(document.getElementById('poMonthlyChart'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'PO Amount',
            data: mapMonths(poMonthly),
            borderColor: '#334155',
            backgroundColor: 'rgba(51,65,85,0.15)',
            fill: true,
            tension: 0.4
        }]
    }
});
</script>

@endsection
