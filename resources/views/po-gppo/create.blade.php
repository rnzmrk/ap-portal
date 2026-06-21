@extends('components.app')

@section('content')

<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Create PO-GPPO
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Submit a new PO-GPPO record.
            </p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <form action="{{ route(auth()->user()->role . '.po-gppo.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Invoice No -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Invoice No
                    </label>
                    <input type="text" name="invoice_no" placeholder="Enter invoice number"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('invoice_no') border-red-500 @enderror"
                        value="{{ old('invoice_no') }}" required>
                    @error('invoice_no')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PO No -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        PO No
                    </label>
                    <input type="text" name="po_no" placeholder="Enter PO number"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('po_no') border-red-500 @enderror"
                        value="{{ old('po_no') }}" required>
                    @error('po_no')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Amount -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Amount
                    </label>
                    <input type="number" name="amount" placeholder="Enter amount" step="0.01"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('amount') border-red-500 @enderror"
                        value="{{ old('amount') }}" required>
                    @error('amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Files -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Files
                    </label>
                    <input  id="file-input"
                            type="file"
                            name="files[]"
                            multiple
                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('files') border-red-500 @enderror"
                        >
                    <p class="text-slate-500 text-sm mt-1">Accepted: PDF, DOC, DOCX, JPG, PNG</p>
                    @error('files')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <div id="selected-files" class="mt-4 rounded-lg border border-slate-200 bg-slate-50 p-4 hidden">
                        <p class="text-sm font-medium text-slate-700 mb-2">Selected files</p>
                        <ul class="space-y-2 text-sm text-slate-700"></ul>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-6 border-t">
                    <a href="{{ route(auth()->user()->role . '.po-gppo.index') }}" class="px-4 py-2 text-slate-600 border border-slate-300 rounded-lg hover:bg-slate-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('file-input');
    const selectedFilesContainer = document.getElementById('selected-files');
    const selectedFilesList = selectedFilesContainer.querySelector('ul');

    fileInput.addEventListener('change', function () {
        selectedFilesList.innerHTML = '';

        if (!this.files.length) {
            selectedFilesContainer.classList.add('hidden');
            return;
        }

        Array.from(this.files).forEach(file => {
            const li = document.createElement('li');

            li.className = 'flex items-center justify-between gap-3 rounded-md bg-white p-3 border border-slate-200';

            li.innerHTML = `
                <div>
                    <p class="font-medium">${file.name}</p>
                    <p class="text-xs text-slate-500">
                        ${(file.size / 1024).toFixed(1)} KB
                    </p>
                </div>
            `;

            selectedFilesList.appendChild(li);
        });

        selectedFilesContainer.classList.remove('hidden');
    });
});
</script>

@endsection
