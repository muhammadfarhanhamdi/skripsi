<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $from = Carbon::parse($request->input('from', now()->startOfMonth()));
        $to = Carbon::parse($request->input('to', now()->endOfMonth()));

        $transactions = Transaction::with(['customer', 'service', 'kasir', 'promotion'])
            ->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()])
            ->get();

        return view('admin.reports.index', compact('transactions', 'from', 'to'));
    }
}
