<?php

namespace App\Http\Controllers;

use App\Models\JoEvaluation;
use App\Models\PoGppo;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return match (auth()->user()->role) {
            'supplier' => redirect()->route('supplier.dashboard'),
            'procurement' => redirect()->route('procurement.dashboard'),
            'finance' => redirect()->route('finance.dashboard'),
            'operations' => redirect()->route('operations.dashboard'),
            default => abort(403),
        };
    }

public function supplierDashboard()
{
    $userId = auth()->id();

    // =========================
    // BASIC TOTALS
    // =========================
    $allJo = JoEvaluation::where('user_id', $userId)->count();
    $allPo = PoGppo::where('user_id', $userId)->count();

    $totalJoAmount = JoEvaluation::where('user_id', $userId)->sum('amount');
    $totalPoAmount = PoGppo::where('user_id', $userId)->sum('amount');

    // =========================
    // JO STATUS GROUPED
    // =========================
    $joStatuses = JoEvaluation::where('user_id', $userId)
        ->selectRaw('status, COUNT(*) as total')
        ->groupBy('status')
        ->pluck('total', 'status');

    $approvedJo = ($joStatuses['operation_approved'] ?? 0)
                + ($joStatuses['evaluation_approved'] ?? 0);

    $rejectedJo = ($joStatuses['operation_rejected'] ?? 0)
                + ($joStatuses['procurement_rejected'] ?? 0);

    $releasedJo = $joStatuses['payment_for_release'] ?? 0;
    $pendingJo  = $joStatuses['pending'] ?? 0;

    // =========================
    // PO STATUS GROUPED
    // =========================
    $poStatuses = PoGppo::where('user_id', $userId)
        ->selectRaw('status, COUNT(*) as total')
        ->groupBy('status')
        ->pluck('total', 'status');

    $approvedPo  = $poStatuses['approved'] ?? 0;
    $continuedPo = $poStatuses['continued'] ?? 0;
    $releasedPo  = $poStatuses['released'] ?? 0;
    $returnedPo  = $poStatuses['returned_for_compliance'] ?? 0;
    $pendingPo   = $poStatuses['pending'] ?? 0;

    // =========================
    // AMOUNT BY STATUS
    // =========================
    $pendingJoAmount = JoEvaluation::where('user_id', $userId)
        ->where('status', 'pending')
        ->sum('amount');

    $releasedJoAmount = JoEvaluation::where('user_id', $userId)
        ->where('status', 'payment_for_release')
        ->sum('amount');

    $pendingPoAmount = PoGppo::where('user_id', $userId)
        ->where('status', 'pending')
        ->sum('amount');

    $releasedPoAmount = PoGppo::where('user_id', $userId)
        ->where('status', 'released')
        ->sum('amount');

    // =========================
    // MONTHLY JO AMOUNT
    // =========================
    $joMonthly = JoEvaluation::where('user_id', $userId)
        ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

    // =========================
    // MONTHLY PO AMOUNT
    // =========================
    $poMonthly = PoGppo::where('user_id', $userId)
        ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

    return view('supplier.dashboard', compact(
        'allJo',
        'allPo',
        'totalJoAmount',
        'totalPoAmount',

        'approvedJo',
        'rejectedJo',
        'releasedJo',
        'pendingJo',

        'approvedPo',
        'continuedPo',
        'releasedPo',
        'returnedPo',
        'pendingPo',

        'pendingJoAmount',
        'releasedJoAmount',

        'pendingPoAmount',
        'releasedPoAmount',

        'joMonthly',
        'poMonthly'
    ));
}

    public function procurementDashboard()
       {  // =========================
    // BASIC TOTALS
    // =========================
    $allJo = JoEvaluation::count();
    $allPo = PoGppo::count();

    $totalJoAmount = JoEvaluation::sum('amount');
    $totalPoAmount = PoGppo::sum('amount');

    // =========================
    // JO STATUS GROUPED
    // =========================
    $joStatuses = JoEvaluation::selectRaw('status, COUNT(*) as total')
        ->groupBy('status')
        ->pluck('total', 'status');

    $approvedJo = ($joStatuses['operation_approved'] ?? 0)
                + ($joStatuses['evaluation_approved'] ?? 0);

    $rejectedJo = ($joStatuses['operation_rejected'] ?? 0)
                + ($joStatuses['procurement_rejected'] ?? 0);

    $releasedJo = $joStatuses['payment_for_release'] ?? 0;
    $pendingJo  = $joStatuses['pending'] ?? 0;

    // =========================
    // PO STATUS GROUPED
    // =========================
    $poStatuses = PoGppo::selectRaw('status, COUNT(*) as total')
        ->groupBy('status')
        ->pluck('total', 'status');

    $approvedPo  = $poStatuses['approved'] ?? 0;
    $continuedPo = $poStatuses['continued'] ?? 0;
    $releasedPo  = $poStatuses['released'] ?? 0;
    $returnedPo  = $poStatuses['returned_for_compliance'] ?? 0;
    $pendingPo   = $poStatuses['pending'] ?? 0;

    // =========================
    // 
    // =========================
    $pendingJoAmount = JoEvaluation::where('status', 'pending')->sum('amount');
    $releasedJoAmount = JoEvaluation::where('status', 'payment_for_release')->sum('amount');

    $pendingPoAmount = PoGppo::where('status', 'pending')->sum('amount');
    $releasedPoAmount = PoGppo::where('status', 'released')->sum('amount');

    // =========================
    // MONTHLY JO AMOUNT
    // =========================
    $joMonthly = JoEvaluation::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

    // =========================
    // MONTHLY PO AMOUNT
    // =========================
    $poMonthly = PoGppo::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

    // =========================
    // RETURN VIEW
    // =========================
    return view('procurement.dashboard', compact(
        'allJo',
        'allPo',
        'totalJoAmount',
        'totalPoAmount',
        'approvedJo',
        'rejectedJo',
        'releasedJo',
        'pendingJo',
        'approvedPo',
        'continuedPo',
        'releasedPo',
        'returnedPo',
        'pendingPo',
        'joMonthly',
        'poMonthly',
        'pendingJoAmount',
        'releasedJoAmount',
        'pendingPoAmount',
        'releasedPoAmount',
    ));
    }
  
    public function financeDashboard()
    {
        // =========================
        // BASIC TOTALS
        // =========================
        $allJo = JoEvaluation::count();
        $allPo = PoGppo::count();

        $totalJoAmount = JoEvaluation::sum('amount');
        $totalPoAmount = PoGppo::sum('amount');

        // =========================
        // JO STATUS GROUPED
        // =========================
        $joStatuses = JoEvaluation::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $approvedJo = ($joStatuses['operation_approved'] ?? 0)
                    + ($joStatuses['evaluation_approved'] ?? 0);

        $rejectedJo = ($joStatuses['operation_rejected'] ?? 0)
                    + ($joStatuses['procurement_rejected'] ?? 0);

        $releasedJo = $joStatuses['payment_for_release'] ?? 0;
        $pendingJo  = $joStatuses['pending'] ?? 0;

        // =========================
        // PO STATUS GROUPED
        // =========================
        $poStatuses = PoGppo::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $approvedPo  = $poStatuses['approved'] ?? 0;
        $continuedPo = $poStatuses['continued'] ?? 0;
        $releasedPo  = $poStatuses['released'] ?? 0;
        $returnedPo  = $poStatuses['returned_for_compliance'] ?? 0;
        $pendingPo   = $poStatuses['pending'] ?? 0;

        // =========================
        // 
        // =========================
        $pendingJoAmount = JoEvaluation::where('status', 'pending')->sum('amount');
        $releasedJoAmount = JoEvaluation::where('status', 'payment_for_release')->sum('amount');

        $pendingPoAmount = PoGppo::where('status', 'pending')->sum('amount');
        $releasedPoAmount = PoGppo::where('status', 'released')->sum('amount');

        // =========================
        // MONTHLY JO AMOUNT
        // =========================
        $joMonthly = JoEvaluation::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // =========================
        // MONTHLY PO AMOUNT
        // =========================
        $poMonthly = PoGppo::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // =========================
        // RETURN VIEW
        // =========================
        return view('finance.dashboard', compact(
            'allJo',
            'allPo',
            'totalJoAmount',
            'totalPoAmount',
            'approvedJo',
            'rejectedJo',
            'releasedJo',
            'pendingJo',
            'approvedPo',
            'continuedPo',
            'releasedPo',
            'returnedPo',
            'pendingPo',
            'joMonthly',
            'poMonthly',
            'pendingJoAmount',
            'releasedJoAmount',
            'pendingPoAmount',
            'releasedPoAmount',
        ));
    }


    public function operationsDashboard()
    {  // =========================
    // BASIC TOTALS
    // =========================
    $allJo = JoEvaluation::count();
    $allPo = PoGppo::count();

    $totalJoAmount = JoEvaluation::sum('amount');
    $totalPoAmount = PoGppo::sum('amount');

    // =========================
    // JO STATUS GROUPED
    // =========================
    $joStatuses = JoEvaluation::selectRaw('status, COUNT(*) as total')
        ->groupBy('status')
        ->pluck('total', 'status');

    $approvedJo = ($joStatuses['operation_approved'] ?? 0)
                + ($joStatuses['evaluation_approved'] ?? 0);

    $rejectedJo = ($joStatuses['operation_rejected'] ?? 0)
                + ($joStatuses['procurement_rejected'] ?? 0);

    $releasedJo = $joStatuses['payment_for_release'] ?? 0;
    $pendingJo  = $joStatuses['pending'] ?? 0;

    // =========================
    // PO STATUS GROUPED
    // =========================
    $poStatuses = PoGppo::selectRaw('status, COUNT(*) as total')
        ->groupBy('status')
        ->pluck('total', 'status');

    $approvedPo  = $poStatuses['approved'] ?? 0;
    $continuedPo = $poStatuses['continued'] ?? 0;
    $releasedPo  = $poStatuses['released'] ?? 0;
    $returnedPo  = $poStatuses['returned_for_compliance'] ?? 0;
    $pendingPo   = $poStatuses['pending'] ?? 0;

    // =========================
    // 
    // =========================
    $pendingJoAmount = JoEvaluation::where('status', 'pending')->sum('amount');
    $releasedJoAmount = JoEvaluation::where('status', 'payment_for_release')->sum('amount');

    $pendingPoAmount = PoGppo::where('status', 'pending')->sum('amount');
    $releasedPoAmount = PoGppo::where('status', 'released')->sum('amount');

    // =========================
    // MONTHLY JO AMOUNT
    // =========================
    $joMonthly = JoEvaluation::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

    // =========================
    // MONTHLY PO AMOUNT
    // =========================
    $poMonthly = PoGppo::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

    // =========================
    // RETURN VIEW
    // =========================
    return view('opretation.dashboard', compact(
        'allJo',
        'allPo',
        'totalJoAmount',
        'totalPoAmount',
        'approvedJo',
        'rejectedJo',
        'releasedJo',
        'pendingJo',
        'approvedPo',
        'continuedPo',
        'releasedPo',
        'returnedPo',
        'pendingPo',
        'joMonthly',
        'poMonthly',
        'pendingJoAmount',
        'releasedJoAmount',
        'pendingPoAmount',
        'releasedPoAmount',
    ));
    }
}
