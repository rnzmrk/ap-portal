<?php

namespace App\Http\Controllers;

use App\Models\PoGppo;
use App\Services\PoGppoService;
use App\Http\Requests\PoGppo\StorePoGppoRequest;
use App\Http\Requests\PoGppo\UpdatePoGppoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PoGppoController extends Controller
{
    public function __construct(
        protected PoGppoService $poGppoService
    ) {}

    public function index(Request $request)
    {
        $records = $this->poGppoService->getRecords(
            $request->search,
            $request->status,
            $request->from_date,
            $request->to_date
        );

        return view('po-gppo.index', compact('records'));
    }

    public function create()
    {
        return view('po-gppo.create');
    }

    public function store(StorePoGppoRequest $request)
    {
        $this->poGppoService->store($request);

        return redirect()
            ->route(auth()->user()->role . '.po-gppo.index')
            ->with('success', 'PO-GPPO submitted successfully.');
    }

    public function show(PoGppo $poGppo)
    {
        $this->authorize('view', $poGppo);

        return view('po-gppo.show', compact('poGppo'));
    }

    public function file(PoGppo $poGppo, int $index, Request $request)
    {
        $this->authorize('view', $poGppo);

        $files = $poGppo->files ?? [];

        if (!is_array($files) || !array_key_exists($index, $files)) {
            abort(404);
        }

        $file = $files[$index];

        if (is_string($file)) {
            $path = $file;
            $name = basename($file);
        } elseif (is_array($file) && isset($file['path'])) {
            $path = $file['path'];
            $name = $file['original_name'] ?? basename($file['path']);
        } else {
            abort(404);
        }

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $download = $request->boolean('download');

        if ($download) {
            return Storage::disk('public')->download($path, $name);
        }

        return Storage::disk('public')->response($path, $name, [
            'Content-Disposition' => 'inline; filename="' . $name . '"',
        ]);
    }

    public function edit(PoGppo $poGppo)
    {
        $this->authorize('update', $poGppo);

        return view('po-gppo.edit', compact('poGppo'));
    }

    public function update(
        UpdatePoGppoRequest $request,
        PoGppo $poGppo
    ) {
        $this->authorize('update', $poGppo);

        $this->poGppoService->update(
            $poGppo,
            $request
        );

        return redirect()
            ->route(auth()->user()->role . '.po-gppo.index')
            ->with('success', 'PO-GPPO updated successfully.');
    }

    public function destroy(PoGppo $poGppo)
    {
        $this->authorize('delete', $poGppo);

        $this->poGppoService->delete($poGppo);

        return redirect()
            ->route(auth()->user()->role . '.po-gppo.index')
            ->with('success', 'PO-GPPO deleted successfully.');
    }
}
