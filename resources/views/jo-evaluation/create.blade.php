@extends('components.app')

@section('content')

<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Create JO Evaluation
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Submit a new job order evaluation.
            </p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <form action="{{ route(auth()->user()->role . '.jo-evaluation.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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

                <!-- Accomplishment No -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Accomplishment No
                    </label>
                    <input type="text" name="accomplishment_no" placeholder="Enter accomplishment number"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('accomplishment_no') border-red-500 @enderror"
                        value="{{ old('accomplishment_no') }}" required>
                    @error('accomplishment_no')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- JO Reference -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        JO Reference
                    </label>
                    <input type="text" name="jo_reference" placeholder="Enter JO reference"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jo_reference') border-red-500 @enderror"
                        value="{{ old('jo_reference') }}" required>
                    @error('jo_reference')
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
                    <input id="file-input" type="file" name="files[]" multiple
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('files') border-red-500 @enderror"
                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                    <p class="text-slate-500 text-sm mt-1">Accepted: PDF, DOC, DOCX, JPG, PNG</p>
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

                    <div id="selected-files" class="mt-4 rounded-lg border border-slate-200 bg-slate-50 p-4 hidden">
                        <p class="text-sm font-medium text-slate-700 mb-2">Selected files</p>
                        <ul class="space-y-2 text-sm text-slate-700"></ul>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-6 border-t">
                    <a href="{{ route(auth()->user()->role . '.jo-evaluation.index') }}" class="px-4 py-2 text-slate-600 border border-slate-300 rounded-lg hover:bg-slate-50">
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
            fileCountBadge.textContent = `${selectedFiles.length} file${selectedFiles.length === 1 ? '' : 's'} selected`;
        }

        fileInput.addEventListener('change', function () {
            const newFiles = Array.from(fileInput.files);
            fileInput.value = '';

            newFiles.forEach((file) => {
                const duplicate = selectedFiles.some((existing) =>
                    existing.name === file.name && existing.size === file.size && existing.lastModified === file.lastModified
                );

                if (!duplicate) {
                    selectedFiles.push(file);
                }
            });

            updateFileInput();
            renderSelectedFiles();
        });

        selectedFilesList.addEventListener('click', function (event) {
            const button = event.target.closest('.remove-file');
            if (!button) {
                return;
            }

            const index = Number(button.dataset.index);
            selectedFiles.splice(index, 1);
            updateFileInput();
            renderSelectedFiles();
        });

        renderSelectedFiles();
    });
</script>

@endsection
