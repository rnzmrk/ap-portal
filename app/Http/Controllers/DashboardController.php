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
        $user = auth()->user();

        $totalJo = JoEvaluation::where('user_id', $user->id)->count();
        $totalPo = PoGppo::where('user_id', $user->id)->count();

        $totalJoAmount = JoEvaluation::where('user_id', $user->id)->sum('amount');
        $totalPoAmount = PoGppo::where('user_id', $user->id)->sum('amount');

        return view('supplier.dashboard', compact(
            'totalJo',
            'totalPo',
            'totalJoAmount',
            'totalPoAmount'
        ));
    }

    public function procurementDashboard()
    {
        $pendingJo = JoEvaluation::where('status', 'for_procurement_review')->count();

        $approvedJo = JoEvaluation::where('status', 'evaluation_approved')->count();

        $rejectedJo = JoEvaluation::where('status', 'procurement_rejected')->count();

        return view('procurement.dashboard', compact(
            'pendingJo',
            'approvedJo',
            'rejectedJo'
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
            'poMonthly'
        ));
    }

   
    public function operationsDashboard()
    {
        $pendingReview = JoEvaluation::where(
            'status',
            'for_operation_review'
        )->count();

        $approved = JoEvaluation::where(
            'status',
            'operation_approved'
        )->count();

        $rejected = JoEvaluation::where(
            'status',
            'operation_rejected'
        )->count();

        return view('operation.dashboard', compact(
            'pendingReview',
            'approved',
            'rejected'
        ));
    }
}