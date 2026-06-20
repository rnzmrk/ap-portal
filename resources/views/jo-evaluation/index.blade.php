@extends('components.app')

@section('content')

@php
    $isStaff = in_array(auth()->user()->role, ['procurement', 'finance', 'operations']);
@endphp

<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                JO Evaluation Management
            </h1>

            <p class="text-sm text-slate-500">
                Manage all submitted JO Evaluation records.
            </p>
        </div>

        @if(auth()->user()->role === 'supplier')
        <a href="{{ route(auth()->user()->role . '.jo-evaluation.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">

            <i class="bi bi-plus-circle"></i>
            New JO Evaluation
        </a>
        @endif

    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search + Filter -->
    <div class="bg-white rounded-xl shadow-sm p-4">

        <form method="GET" class="grid md:grid-cols-3 gap-3">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search invoice, accomplishment, or JO reference..."
                class="border rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-red-500">

            <select name="status" class="border rounded-lg px-3 py-2">

                <option value="" {{ request('status') === null || request('status') === '' ? 'selected' : '' }}>All Status</option>

                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>

                <option value="for_operation_review" {{ request('status') === 'for_operation_review' ? 'selected' : '' }}>
                    For Operation Review
                </option>

                <option value="operation_approved" {{ request('status') === 'operation_approved' ? 'selected' : '' }}>
                    Operation Approved
                </option>

                <option value="operation_rejected" {{ request('status') === 'operation_rejected' ? 'selected' : '' }}>
                    Operation Rejected
                </option>

                <option value="for_procurement_review" {{ request('status') === 'for_procurement_review' ? 'selected' : '' }}>
                    For Procurement Review
                </option>

                <option value="evaluation_approved" {{ request('status') === 'evaluation_approved' ? 'selected' : '' }}>
                    Evaluation Approved
                </option>

                <option value="procurement_rejected" {{ request('status') === 'procurement_rejected' ? 'selected' : '' }}>
                    Procurement Rejected
                </option>

                <option value="continued" {{ request('status') === 'continued' ? 'selected' : '' }}>
                    Continued
                </option>

                <option value="payment_for_release" {{ request('status') === 'payment_for_release' ? 'selected' : '' }}>
                    Payment For Release
                </option>

            </select>

            <div class="flex gap-3">
                <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Apply
                </button>
                <a href="{{ route(auth()->user()->role . '.jo-evaluation.index') }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-100">
                    Reset
                </a>
            </div>
        </form>

    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[1100px]">

                <thead class="bg-red-600 text-white">

                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        @if($isStaff)
                        <th class="px-4 py-3 text-left">Supplier Name</th>
                        @endif
                        <th class="px-4 py-3 text-left">Invoice No</th>
                        <th class="px-4 py-3 text-left">Accomplishment No</th>
                        <th class="px-4 py-3 text-left">JO Reference</th>
                        <th class="px-4 py-3 text-left">Amount</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Files</th>
                        <th class="px-4 py-3 text-left">Created</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($records as $record)

                        <tr class="border-b hover:bg-slate-50">

                            <td class="px-4 py-3">
                                {{ $record->id }}
                            </td>

                            @if($isStaff)
                            <td class="px-4 py-3">
                                {{ $record->user->name ?? '—' }}
                            </td>
                            @endif

                            <td class="px-4 py-3">
                                {{ $record->invoice_no }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $record->accomplishment_no }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $record->jo_reference }}
                            </td>

                            <td class="px-4 py-3">
                                ₱ {{ number_format($record->amount, 2) }}
                            </td>

                            <td class="px-4 py-3">
                                @php
                                    $statusConfig = [

                                        'pending' => [
                                            'label' => 'Pending',
                                            'class' => 'bg-yellow-100 text-yellow-700'
                                        ],

                                        'for_operation_review' => [
                                            'label' => 'For Operation Review',
                                            'class' => 'bg-blue-100 text-blue-700'
                                        ],

                                        'operation_approved' => [
                                            'label' => 'Operation Approved',
                                            'class' => 'bg-green-100 text-green-700'
                                        ],

                                        'operation_rejected' => [
                                            'label' => 'Operation Rejected',
                                            'class' => 'bg-red-100 text-red-700'
                                        ],

                                        'for_procurement_review' => [
                                            'label' => 'For Procurement Review',
                                            'class' => 'bg-indigo-100 text-indigo-700'
                                        ],

                                        'evaluation_approved' => [
                                            'label' => 'Evaluation Approved',
                                            'class' => 'bg-green-100 text-green-700'
                                        ],

                                        'procurement_rejected' => [
                                            'label' => 'Procurement Rejected',
                                            'class' => 'bg-red-100 text-red-700'
                                        ],

                                        'continued' => [
                                            'label' => 'Continued',
                                            'class' => 'bg-emerald-100 text-emerald-700'
                                        ],

                                        'payment_for_release' => [
                                            'label' => 'Payment For Release',
                                            'class' => 'bg-purple-100 text-purple-700'
                                        ],

                                    ];

                                    $status = $statusConfig[$record->status] ?? [
                                        'label' => ucfirst(str_replace('_', ' ', $record->status)),
                                        'class' => 'bg-slate-100 text-slate-700'
                                    ];
                                @endphp

                                <span class="px-3 py-1 text-xs rounded-full {{ $status['class'] }}">
                                    {{ $status['label'] }}
                                </span>

                            </td>

                            <td class="px-4 py-3">
                                <a href="{{ route(auth()->user()->role . '.jo-evaluation.show', $record->id) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                    <i class="bi bi-folder2-open"></i>
                                    View Files ({{ is_array($record->files) ? count($record->files) : 0 }})
                                </a>
                            </td>

                            <td class="px-4 py-3">
                                {{ $record->created_at->format('M d, Y') }}
                            </td>

                            <td class="px-4 py-3">

                                <div class="flex justify-center gap-2">

                                    <!-- View -->
                                    <a href="{{ route(auth()->user()->role.'.jo-evaluation.show', $record->id) }}"
                                       class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-2 rounded">

                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if(auth()->user()->role !== 'supplier')
                                        <!-- Edit -->
                                        @can('edit', $record)
                                        <a href="{{ route(auth()->user()->role.'.jo-evaluation.edit', $record->id) }}"
                                           class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-3 py-2 rounded">

                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        @endcan

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="{{ $isStaff ? 10 : 9 }}"
                                class="text-center py-10 text-slate-500">

                                No JO Evaluation records found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
