<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::query();

        if ($request->filled('from') && $request->filled('to')) {
            $from = Carbon::parse($request->input('from'));
            $to = Carbon::parse($request->input('to'));
            $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
        }

        $transactions = $query->with(['customer', 'service', 'kasir', 'promotion'])->paginate(12);

        return view('admin.transactions.index', compact('transactions'));
    }

    public function report(Request $request)
    {
        $from = Carbon::parse($request->input('from', now()->startOfMonth()));
        $to = Carbon::parse($request->input('to', now()->endOfMonth()));

        $transactions = Transaction::with(['customer', 'service', 'kasir', 'promotion'])
            ->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()])
            ->get();

        return view('admin.transactions.report', compact('transactions', 'from', 'to'));
    }
}
