@extends('components.app')

@section('content')

<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                JO Evaluation Details
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                View job order evaluation information.
            </p>
        </div>

        <div class="flex gap-3">
            @if(auth()->user()->role !== 'supplier' && auth()->user()->can('edit', $joEvaluation))
                <a href="{{ route(auth()->user()->role . '.jo-evaluation.edit', $joEvaluation) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Edit
                </a>
            @endif
            <a href="{{ route(auth()->user()->role . '.jo-evaluation.index') }}" class="px-4 py-2 text-slate-600 border border-slate-300 rounded-lg hover:bg-slate-50">
                Back
            </a>
        </div>
    </div>

    <!-- Details Card -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 space-y-6">
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <p class="text-sm text-slate-500">Invoice No</p>
                    <p class="mt-1 text-base font-semibold text-slate-800">{{ $joEvaluation->invoice_no }}</p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Accomplishment No</p>
                    <p class="mt-1 text-base font-semibold text-slate-800">{{ $joEvaluation->accomplishment_no }}</p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">JO No</p>
                    <p class="mt-1 text-base font-semibold text-slate-800">{{ $joEvaluation->jo_reference }}</p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">DR No</p>
                    <p class="mt-1 text-base font-semibold text-slate-800">₱ {{ $joEvaluation->dr_no }}</p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Amount</p>
                    <p class="mt-1 text-base font-semibold text-slate-800">₱ {{ number_format($joEvaluation->amount, 2) }}</p>
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">

                <div>
                    <p class="text-sm text-slate-500">Amount Details</p>
                    <p class="mt-1 text-base font-semibold text-slate-800">₱ {{ number_format($joEvaluation->amount_details, 2) }}</p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Check No</p>
                    <p class="mt-1 text-base font-semibold text-slate-800">{{ $joEvaluation->check_no }}</p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Release Location</p>
                    <p class="mt-1 text-base font-semibold text-slate-800">{{ $joEvaluation->release_location }}</p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Status</p>
                    <p class="mt-1 text-base font-semibold text-slate-800">{{ ucfirst(str_replace('_', ' ', $joEvaluation->status)) }}</p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Submitted Date</p>
                    <p class="mt-1 text-base font-semibold text-slate-800">{{ $joEvaluation->created_at->format('M d, Y h:i A') }}</p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Rejection Reason</p>
                    <p class="mt-1 text-base font-semibold text-slate-800">{{ $joEvaluation->rejection_reason }}</p>
                </div>
            </div>

            <div class="border-t pt-6">
                <p class="text-sm text-slate-500 mb-3">Uploaded Files</p>
                @if(!empty($joEvaluation->files) && is_array($joEvaluation->files))
                    <div class="space-y-6">
                        @foreach($joEvaluation->files as $file)
                            @php
                                $path = is_array($file) ? ($file['path'] ?? '') : $file;
                                $name = is_array($file) ? ($file['original_name'] ?? basename($path)) : basename($path);
                                $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                $viewUrl = route('jo-evaluation.file', ['joEvaluation' => $joEvaluation->id, 'index' => $loop->index]);
                                $downloadUrl = route('jo-evaluation.file', ['joEvaluation' => $joEvaluation->id, 'index' => $loop->index, 'download' => 1]);
                            @endphp

                            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                    <div class="min-w-0">
                                        <p class="font-medium text-slate-800 truncate">{{ $name }}</p>
                                        <p class="text-slate-500 text-sm">{{ strtoupper($extension) }} file</p>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ $viewUrl }}" target="_blank" class="px-3 py-2 rounded-lg bg-blue-600 text-white text-sm hover:bg-blue-700">Open</a>
                                        <a href="{{ $downloadUrl }}" class="px-3 py-2 rounded-lg border border-slate-300 text-slate-700 text-sm hover:bg-slate-100">Download</a>
                                    </div>
                                </div>

                                @if(in_array($extension, ['png', 'jpg', 'jpeg', 'gif', 'bmp', 'webp']))
                                    <div class="mt-4 rounded-lg overflow-hidden border border-slate-200">
                                        <img src="{{ $viewUrl }}" alt="{{ $name }}" class="w-full h-auto object-contain" />
                                    </div>
                                @elseif($extension === 'pdf')
                                    <div class="mt-4 rounded-lg overflow-hidden border border-slate-200" style="min-height: 50vh;">
                                        <iframe src="{{ $viewUrl }}" class="w-full h-[50vh] min-h-[320px]" frameborder="0"></iframe>
                                    </div>
                                @else
                                    <p class="mt-4 text-slate-600 text-sm">Preview unavailable for this file type. Use the Open or Download buttons.</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-500">No files uploaded.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
