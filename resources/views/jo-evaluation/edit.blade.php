@extends('components.app')

@section('content')

<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                @if(auth()->user()->role === 'supplier')
                    Edit JO Evaluation
                @else
                    Update JO Evaluation Status
                @endif
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                @if(auth()->user()->role === 'supplier')
                    Update job order evaluation details.
                @else
                    Update the status of the job order evaluation.
                @endif
            </p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <form action="{{ route(auth()->user()->role . '.jo-evaluation.update', $joEvaluation) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                @if(auth()->user()->role != 'supplier')
                    <!-- Not Supplier Edit View - Full Form -->

                    <!-- Read-only Display of JO Details -->
                    <div class="grid gap-6 md:grid-cols-2 p-4 bg-slate-50 rounded-lg">
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
                            <p class="mt-1 text-base font-semibold text-slate-800">{{ $joEvaluation->dr_no }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Amount</p>
                            <p class="mt-1 text-base font-semibold text-slate-800">₱ {{ number_format($joEvaluation->amount, 2) }}</p>
                        </div>
                    </div>

                    <!-- Status Update -->
                    <div class="border-t pt-6">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror" required>
                            <option value="">Select Status</option>
                            <option value="pending" {{ old('status', $joEvaluation->status) === 'pending' ? 'selected' : '' }}>Pending (For Operation)</option>s
                            <option value="operation_approved" {{ old('status', $joEvaluation->status) === 'operation_approved' ? 'selected' : '' }}>Operation Approved</option>
                            <option value="operation_rejected" {{ old('status', $joEvaluation->status) === 'operation_rejected' ? 'selected' : '' }}>Operation Rejected</option>
                            <option value="evaluation_approved" {{ old('status', $joEvaluation->status) === 'evaluation_approved' ? 'selected' : '' }}>Evaluation Approved (Proceed For Countering)</option>
                            <option value="procurement_rejected" {{ old('status', $joEvaluation->status) === 'procurement_rejected' ? 'selected' : '' }}>Procurement Rejected</optiosn>
                            <option value="countered" {{ request('status')=='countered'?'selected':'' }}>Countered/Received</option>
                            <option value="payment_for_release" {{ old('status', $joEvaluation->status) === 'payment_for_release' ? 'selected' : '' }}>Payment For Release</option>
                            <option value="released" {{ request('status')=='released'?'selected':'' }}>Released</option>
                            <option value="paid" {{ request('status')=='paid'?'selected':'' }}>Paid</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border-t pt-6">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Rejection Reason
                        </label>

                        <textarea name="rejection_reason" rows="4"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg"
                            placeholder="Enter rejection reason">
                            {{ old('return_reason', $joEvaluation->rejection_reason) }}
                        </textarea>
                    </div>

                    <div class="border-t pt-6 grid gap-6 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Amount Details
                            </label>
                            <textarea name="amount_details" rows="3"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('amount_details') border-red-500 @enderror"
                                placeholder="Enter payment details">{{ old('payment_details', $joEvaluation->amount_details) }}</textarea>
                            @error('amount_details')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Check No
                            </label>
                            <input type="text" name="check_no"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('check_no') border-red-500 @enderror"
                                value="{{ old('check_no', $joEvaluation->check_no) }}"
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
                                value="{{ old('release_location', $joEvaluation->release_location) }}"
                                placeholder="Enter release location">
                            @error('release_location')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Evaluation File -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Evaluations File <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="evaluation-files"
                                type="file"
                                name="evaluation_files[]"
                                accept=".pdf"
                                multiple
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('evaluation_files') border-red-500 @enderror">

                            <p class="text-slate-500 text-sm mt-1">
                                Accepted format: PDF only
                            </p>

                            @error('evaluation_files')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                            @if(is_array($joEvaluation->evaluation_files) && count($joEvaluation->evaluation_files))

                                <div class="mt-3 space-y-2">

                                    @foreach($joEvaluation->evaluation_files as $file)

                                        @if(!empty($file['path']))

                                            <a href="{{ Storage::url($file['path']) }}"
                                            target="_blank"
                                            class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline">

                                                <i class="bi bi-file-earmark-pdf-fill text-red-500"></i>

                                                {{ $file['original_name'] ?? basename($file['path']) }}

                                            </a>

                                        @endif

                                    @endforeach

                                </div>

                            @endif

                            <div id="selected-evaluation-file"
                                class="mt-4 rounded-lg border border-slate-200 bg-slate-50 p-4 hidden">

                                <p class="text-sm font-medium text-slate-700 mb-2">
                                    Selected File
                                </p>

                                <div class="text-sm text-slate-700"></div>

                            </div>
                        </div>
                    </div>

                @endif

                <div class="flex justify-end gap-3 pt-6 border-t">
                    <a href="{{ route(auth()->user()->role . '.jo-evaluation.index') }}" class="px-4 py-2 text-slate-600 border border-slate-300 rounded-lg hover:bg-slate-50">
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

        // Handle removing existing files
        const existingFilesList = document.getElementById('existing-files-list');
        if (existingFilesList) {
            const removedFiles = [];
            const form = document.querySelector('form');

            // Create hidden input to track removed files
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
