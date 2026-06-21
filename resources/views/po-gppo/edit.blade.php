@extends('components.app')

@section('content')

<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                @if(auth()->user()->role === 'supplier')
                    Edit PO-GPPO
                @else
                    Update PO-GPPO Status
                @endif
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                @if(auth()->user()->role === 'supplier')
                    Update PO-GPPO details.
                @else
                    Update the status of the PO-GPPO record.
                @endif
            </p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <form action="{{ route(auth()->user()->role . '.po-gppo.update', $poGppo) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                @if(auth()->user()->role === 'supplier')
                    <!-- Supplier Edit View -->

                    <!-- Invoice No -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Invoice No
                        </label>
                        <input type="text" name="invoice_no" placeholder="Enter invoice number"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('invoice_no') border-red-500 @enderror"
                            value="{{ old('invoice_no', $poGppo->invoice_no) }}" required>
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
                            value="{{ old('po_no', $poGppo->po_no) }}" required>
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
                            value="{{ old('amount', $poGppo->amount) }}" required>
                        @error('amount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Files -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Files
                        </label>
                        <input id="file-input" type="file" name="files[]" multiple
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('files') border-red-500 @enderror"
                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <p class="text-slate-500 text-sm mt-1">Accepted: PDF, DOC, DOCX, JPG, PNG</p>
                        @error('files')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        @if(!empty($poGppo->files) && is_array($poGppo->files))
                        <div class="mt-4 rounded-lg border border-slate-200 bg-blue-50 p-4">
                            <p class="text-sm font-medium text-slate-700 mb-2">Existing files ({{ count($poGppo->files) }})</p>
                            <ul class="space-y-2 text-sm" id="existing-files-list">
                                @foreach($poGppo->files as $index => $file)
                                @php
                                    $path = is_array($file) ? ($file['path'] ?? '') : $file;
                                    $name = is_array($file) ? ($file['original_name'] ?? basename($path)) : basename($path);
                                @endphp
                                <li class="flex items-center justify-between gap-3 rounded-md bg-white p-3 border border-slate-200" data-file-index="{{ $index }}" data-file-path="{{ $path }}">
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate font-medium text-slate-800">{{ $name }}</p>
                                        <p class="text-slate-500 text-xs">{{ $path }}</p>
                                    </div>
                                    <div class="flex gap-2 whitespace-nowrap">
                                        <a href="{{ route('po-gppo.file', ['poGppo' => $poGppo->id, 'index' => $index, 'download' => 1]) }}"
                                           class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                            Download
                                        </a>
                                        <button type="button" class="text-red-600 hover:text-red-800 text-xs font-medium remove-existing-file">
                                            Remove
                                        </button>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div id="selected-files" class="mt-4 rounded-lg border border-slate-200 bg-slate-50 p-4 hidden">
                            <p class="text-sm font-medium text-slate-700 mb-2">New files to upload</p>
                            <ul class="space-y-2 text-sm text-slate-700"></ul>
                        </div>
                    </div>

                @else
                    <!-- Non-Supplier Edit View - Status Only -->

                    <div class="grid gap-6 md:grid-cols-2 p-4 bg-slate-50 rounded-lg">
                        <div>
                            <p class="text-sm text-slate-500">Invoice No</p>
                            <p class="mt-1 text-base font-semibold text-slate-800">{{ $poGppo->invoice_no }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">PO No</p>
                            <p class="mt-1 text-base font-semibold text-slate-800">{{ $poGppo->po_no }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Amount</p>
                            <p class="mt-1 text-base font-semibold text-slate-800">₱ {{ number_format($poGppo->amount, 2) }}</p>
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror" required>
                            <option value="">Select Status</option>
                            <option value="pending" {{ old('status', $poGppo->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="under_review" {{ old('status', $poGppo->status) === 'under_review' ? 'selected' : '' }}>Under Review</option>
                            <option value="approved_for_continuing" {{ old('status', $poGppo->status) === 'approved_for_continuing' ? 'selected' : '' }}>Approved for Continuing</option>
                            <option value="returned_for_compliance" {{ old('status', $poGppo->status) === 'returned_for_compliance' ? 'selected' : '' }}>Returned for Compliance</option>
                            <option value="continued" {{ old('status', $poGppo->status) === 'continued' ? 'selected' : '' }}>Continued</option>
                            <option value="check_ready_for_release" {{ old('status', $poGppo->status) === 'check_ready_for_release' ? 'selected' : '' }}>Check Ready for Release</option>
                            <option value="released" {{ old('status', $poGppo->status) === 'released' ? 'selected' : '' }}>Released</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border-t pt-6">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Return Reason
                        </label>

                        <textarea name="return_reason" rows="4"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg"
                            placeholder="Enter return reason">
                            {{ old('return_reason', $poGppo->return_reason) }}
                        </textarea>
                    </div>

                    <div class="border-t pt-6 grid gap-6 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Payment Details
                            </label>
                            <textarea name="payment_details" rows="3"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('payment_details') border-red-500 @enderror"
                                placeholder="Enter payment details">{{ old('payment_details', $poGppo->payment_details) }}</textarea>
                            @error('payment_details')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Check No
                            </label>
                            <input type="text" name="check_no"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('check_no') border-red-500 @enderror"
                                value="{{ old('check_no', $poGppo->check_no) }}"
                                placeholder="Enter check number">
                            @error('check_no')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Release Location
                            </label>
                            <input type="text" name="release_location"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('release_location') border-red-500 @enderror"
                                value="{{ old('release_location', $poGppo->release_location) }}"
                                placeholder="Enter release location">
                            @error('release_location')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                @endif

                <div class="flex justify-end gap-3 pt-6 border-t">
                    <a href="{{ route(auth()->user()->role . '.po-gppo.index') }}" class="px-4 py-2 text-slate-600 border border-slate-300 rounded-lg hover:bg-slate-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        @if(auth()->user()->role === 'supplier')
                            Update
                        @else
                            Save Status
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(auth()->user()->role === 'supplier')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('file-input');
        const selectedFilesContainer = document.getElementById('selected-files');
        const selectedFilesList = selectedFilesContainer.querySelector('ul');
        const fileCountBadge = document.createElement('span');
        const selectedFiles = [];

        fileCountBadge.className = 'text-xs text-slate-500';
        fileCountBadge.textContent = 'No files selected';
        selectedFilesContainer.querySelector('p').appendChild(fileCountBadge);

        function updateFileInput() {
            const dt = new DataTransfer();
            selectedFiles.forEach((file) => dt.items.add(file));
            fileInput.files = dt.files;
        }

        function renderSelectedFiles() {
            selectedFilesList.innerHTML = '';

            if (selectedFiles.length === 0) {
                selectedFilesContainer.classList.add('hidden');
                fileCountBadge.textContent = 'No files selected';
                return;
            }

            selectedFiles.forEach((file, index) => {
                const listItem = document.createElement('li');
                listItem.className = 'flex items-center justify-between gap-3 rounded-md bg-white p-3 border border-slate-200';
                listItem.innerHTML = `
                    <div class="min-w-0">
                        <p class="truncate font-medium">${file.name}</p>
                        <p class="text-slate-500 text-xs">${(file.size / 1024).toFixed(1)} KB</p>
                    </div>
                    <button type="button" class="text-red-600 hover:text-red-800 text-xs font-medium remove-file" data-index="${index}">
                        Remove
                    </button>
                `;

                selectedFilesList.appendChild(listItem);
            });

            selectedFilesContainer.classList.remove('hidden');
            fileCountBadge.textContent = `${selectedFiles.length} file(s) selected`;
        }

        fileInput.addEventListener('change', function (e) {
            Array.from(e.target.files).forEach((file) => {
                if (!selectedFiles.find((f) => f.name === file.name && f.size === file.size)) {
                    selectedFiles.push(file);
                }
            });

            renderSelectedFiles();
            updateFileInput();
        });

        selectedFilesList.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-file')) {
                e.preventDefault();
                const index = parseInt(e.target.dataset.index);
                selectedFiles.splice(index, 1);
                renderSelectedFiles();
                updateFileInput();
            }
        });

        const existingFilesList = document.getElementById('existing-files-list');
        if (existingFilesList) {
            const removedFiles = [];
            const form = document.querySelector('form');

            const removedFilesInput = document.createElement('input');
            removedFilesInput.type = 'hidden';
            removedFilesInput.name = 'removed_files';
            removedFilesInput.value = '[]';
            form.appendChild(removedFilesInput);

            existingFilesList.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-existing-file')) {
                    e.preventDefault();
                    const fileItem = e.target.closest('li');
                    const fileIndex = fileItem.dataset.fileIndex;
                    const filePath = fileItem.dataset.filePath;

                    removedFiles.push({index: fileIndex, path: filePath});
                    removedFilesInput.value = JSON.stringify(removedFiles);

                    fileItem.style.transition = 'opacity 0.3s ease';
                    fileItem.style.opacity = '0.5';
                    e.target.textContent = 'Removed';
                    e.target.disabled = true;
                    e.target.classList.add('text-slate-400', 'cursor-not-allowed');
                    e.target.classList.remove('text-red-600', 'hover:text-red-800');
                }
            });
        }
    });
</script>
@endif

@endsection
