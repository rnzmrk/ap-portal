<?php

namespace App\Http\Controllers;

use App\Models\JoEvaluation;
use App\Services\JoEvaluationService;
use App\Http\Requests\JoEvaluation\StoreJoEvaluationRequest;
use App\Http\Requests\JoEvaluation\UpdateJoEvaluationRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class JoEvaluationController extends Controller
{
    public function __construct(
        protected JoEvaluationService $joEvaluationService
    ) {}

    public function index(Request $request)
    {
         $records = $this->joEvaluationService->getRecords(
            $request->search,
            $request->status,
            $request->from_date,
            $request->to_date
        );
        return view('jo-evaluation.index', compact('records'));
    }

    public function create()
    {
        return view('jo-evaluation.create');
    }

    public function store(StoreJoEvaluationRequest $request)
    {
        $this->joEvaluationService->store($request);

        return redirect()
            ->route(auth()->user()->role . '.jo-evaluation.index')
            ->with('success', 'JO Evaluation submitted successfully.');
    }

    public function show(JoEvaluation $joEvaluation)
    {
        $this->authorize('view', $joEvaluation);

        return view('jo-evaluation.show', compact('joEvaluation'));
    }

    public function file(JoEvaluation $joEvaluation, int $index, Request $request)
    {
        $this->authorize('view', $joEvaluation);

        $files = $joEvaluation->files ?? [];

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

    public function evaluationFile(JoEvaluation $joEvaluation)
        {
            $this->authorize('view', $joEvaluation);

            if (!$joEvaluation->evaluation_file) {
                abort(404);
            }

            return Storage::disk('public')->response(
                $joEvaluation->evaluation_file
            );
        }


    public function edit(JoEvaluation $joEvaluation)
    {
        $this->authorize('edit', $joEvaluation);

        return view('jo-evaluation.edit', compact('joEvaluation'));
    }

    public function update(
        UpdateJoEvaluationRequest $request,
        JoEvaluation $joEvaluation
    ) {
        $this->authorize('update', $joEvaluation);

        $this->joEvaluationService->update(
            $joEvaluation,
            $request
        );

        return redirect()
            ->route(auth()->user()->role . '.jo-evaluation.index')
            ->with('success', 'JO Evaluation updated successfully.');
    }

    public function destroy(JoEvaluation $joEvaluation)
    {
        $this->authorize('delete', $joEvaluation);

        $this->joEvaluationService->delete($joEvaluation);

        return redirect()
            ->route(auth()->user()->role . '.jo-evaluation.index')
            ->with('success', 'JO Evaluation deleted successfully.');
    }
}
