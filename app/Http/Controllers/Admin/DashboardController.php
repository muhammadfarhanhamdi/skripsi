<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Transaction::whereNotNull('paid_at')->sum('total');
        $activeUsers = User::where('role', 'kasir')->count();
        $totalOrders = Transaction::count();
        $customers = Customer::count();
        // monthly totals for each month (Jan..Dec) for current year
        $monthlyTotals = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyTotals[] = Transaction::whereNotNull('paid_at')
                ->whereYear('paid_at', now()->year)
                ->whereMonth('paid_at', $m)
                ->sum('total');
        }
        // current month revenue (kept for backward compatibility)
        $monthlyRevenue = $monthlyTotals[now()->month - 1] ?? 0;
        $newCustomers = Customer::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
        $conversionRate = $totalOrders > 0 ? round(($newCustomers / $totalOrders) * 100) : 0;

        return view('admin.dashboard', compact(
            'totalRevenue',
            'activeUsers',
            'totalOrders',
            'customers',
            'monthlyRevenue',
            'monthlyTotals',
            'newCustomers',
            'conversionRate'
        ));
    }
}
