@extends('components.app')

@section('content')

<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Create new Invioce Submission
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Submit a new Invoice record.
            </p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">

            <form action="{{ route(auth()->user()->role . '.po-gppo.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-6">

                @csrf

                <!-- Invoice No -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Invoice No
                    </label>
                    <input type="text" name="invoice_no"
                        value="{{ old('invoice_no') }}"
                        required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('invoice_no')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PO No -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        PO No
                    </label>
                    <input type="text" name="po_no"
                        value="{{ old('po_no') }}"
                        required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('po_no')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- DR No -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        DR No
                    </label>
                    <input type="text" name="dr_no"
                        value="{{ old('dr_no') }}"
                        required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('dr_no')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- GRPO -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        GRPO
                    </label>
                    <input type="text" name="grpo"
                        value="{{ old('grpo') }}"
                        required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('grpo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Amount -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Amount
                    </label>
                    <input type="number" name="amount"
                        step="0.01"
                        value="{{ old('amount') }}"
                        required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Files -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Files
                    </label>

                    <!-- IMPORTANT: CLEAN INPUT (NO JS CONTROL) -->
                    <input
                        type="file"
                        name="files[]"
                        multiple
                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg">

                    <p class="text-slate-500 text-sm mt-1">
                        Accepted: PDF
                    </p>

                    @error('files')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @if ($errors->has('files.*'))
                        <div class="mt-2 space-y-1">
                            @foreach ($errors->get('files.*') as $messages)
                                @foreach ($messages as $message)
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @endforeach
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3 pt-6 border-t">

                    <a href="{{ route(auth()->user()->role . '.po-gppo.index') }}"
                       class="px-4 py-2 text-slate-600 border border-slate-300 rounded-lg hover:bg-slate-50">
                        Cancel
                    </a>

                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Submit
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

@endsection
