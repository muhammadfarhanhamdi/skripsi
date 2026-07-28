<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Booking;
use App\Models\Promotion;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class KasirController extends Controller
{
    public function dashboard()
    {
        $kasirId = Auth::id();

        $transactionCount = Transaction::where('kasir_id', $kasirId)->count();
        $unpaidCount = Transaction::where('kasir_id', $kasirId)->whereNull('paid_at')->count();
        $totalRevenue = Transaction::where('kasir_id', $kasirId)
            ->whereNotNull('paid_at')
            ->sum('total');

        return view('kasir.dashboard', compact('transactionCount', 'unpaidCount', 'totalRevenue'));
    }

    public function create()
    {
        $customers = Customer::orderByDesc('is_member')->orderBy('name')->get();
        $services = Service::orderBy('name')->get();
        $promotions = Promotion::where('active', true)->orderBy('title')->get();

        return view('kasir.transactions', compact('customers', 'services', 'promotions'));
    }

    public function createCustomer()
    {
        $existingMembers = Customer::where('is_member', true)
            ->orderBy('name')
            ->get();

        return view('kasir.customers.create', compact('existingMembers'));
    }

    public function storeCustomer(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'notes' => 'nullable|string|max:500',
            'is_member' => 'sometimes|boolean',
        ]);

        $data['is_member'] = $request->has('is_member');

        Customer::create($data);

        return Redirect::route('kasir.dashboard')->with('status', 'Member berhasil ditambahkan.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'customer_name' => 'required_without:customer_id|string|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'customer_email' => 'nullable|email|max:255',
            'service_id' => 'required|array',
            'service_id.*' => 'exists:services,id',
            'promotion_id' => 'nullable|exists:promotions,id',
            'notes' => 'nullable|string|max:500',
            'is_member' => 'sometimes|boolean',
        ]);

        if (! empty($data['customer_id'])) {
            $customer = Customer::find($data['customer_id']);
            if ($request->has('is_member')) {
                $customer->is_member = true;
                $customer->save();
            }
        } else {
            $customer = Customer::create([
                'name' => $data['customer_name'],
                'phone' => $data['customer_phone'] ?? null,
                'email' => $data['customer_email'] ?? null,
                'notes' => null,
                'is_member' => $request->has('is_member'),
            ]);
        }

        // multiple services support
        $serviceIds = $data['service_id'];
        $servicesSelected = Service::whereIn('id', $serviceIds)->get();

        $promotion = null;
        $discountPercent = 0;
        if (! empty($data['promotion_id'])) {
            $promotion = Promotion::find($data['promotion_id']);
            if ($promotion) {
                $discountPercent = $promotion->discount_percent;
            }
        }

        $priceSum = $servicesSelected->sum('price');
        $total = round($priceSum * (100 - $discountPercent) / 100, 2);

        // create parent transaction (store first service in service_id for compatibility)
        $firstService = $servicesSelected->first();
        $transaction = Transaction::create([
            'customer_id' => $customer->id,
            'service_id' => $firstService?->id ?? $serviceIds[0],
            'kasir_id' => Auth::id(),
            'promotion_id' => $promotion?->id,
            'price' => $priceSum,
            'discount_percent' => $discountPercent,
            'payment_method' => null,
            'total' => $total,
            'paid_at' => null,
        ]);

        // create line items
        foreach ($servicesSelected as $srv) {
            $transaction->items()->create([
                'service_id' => $srv->id,
                'price' => $srv->price,
            ]);
        }

        return Redirect::route('kasir.transactions.receipt', $transaction)->with('status', 'Transaksi berhasil diproses.');
    }

    public function receipt(Transaction $transaction)
    {
        if ($transaction->kasir_id !== Auth::id()) {
            abort(403);
        }

        $transaction->load(['customer', 'service', 'promotion', 'items.service']);
        return view('kasir.receipt', compact('transaction'));
    }

    public function history()
    {
        $memberId = request()->query('member_id');

        $query = Transaction::with(['customer', 'service', 'promotion', 'items.service'])
            ->where('kasir_id', Auth::id());

        if (! empty($memberId)) {
            $query->where('customer_id', $memberId);
        }

        $transactions = $query->latest()->paginate(12);

        $members = \App\Models\Customer::where('is_member', true)->orderBy('name')->get();

        return view('kasir.history', compact('transactions', 'members', 'memberId'));
    }

    public function unpaid()
    {
        $transactions = Transaction::with(['customer', 'service', 'items.service', 'booking'])
            ->whereNull('paid_at')
            ->latest()
            ->paginate(12);

        return view('kasir.unpaid', compact('transactions'));
    }

    

    public function bookings()
    {
        $bookings = Booking::with(['customer', 'service', 'creator', 'items.service'])
            ->latest('booking_date')
            ->latest('booking_time')
            ->paginate(12);

        return view('kasir.bookings.index', compact('bookings'));
    }

    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,confirmed,arrived,completed,canceled',
        ]);

        $booking->update([
            'status' => $data['status'],
        ]);

        return Redirect::route('kasir.bookings')->with('status', 'Status booking berhasil diperbarui.');
    }

    public function convertBookingToTransaction(Booking $booking)
    {
        if ($booking->transaction) {
            return Redirect::route('kasir.bookings')->with('status', 'Booking ini sudah pernah dikonversi menjadi transaksi.');
        }

        if ($booking->status === 'canceled') {
            return Redirect::route('kasir.bookings')->with('status', 'Booking yang dibatalkan tidak dapat dikonversi.');
        }

        $customer = $booking->customer;

        if (! $customer) {
            $customer = Customer::create([
                'name' => $booking->customer_name,
                'phone' => $booking->customer_phone,
                'email' => null,
                'notes' => 'Dibuat otomatis dari booking WhatsApp',
                'is_member' => false,
            ]);
        }

        $bookingItems = $booking->items;
        $primaryService = $booking->service ?? $bookingItems->first()?->service;
        $totalPrice = $bookingItems->sum('price');

        $transaction = Transaction::create([
            'customer_id' => $customer->id,
            'service_id' => $primaryService?->id,
            'booking_id' => $booking->id,
            'kasir_id' => Auth::id(),
            'promotion_id' => null,
            'price' => $totalPrice,
            'discount_percent' => 0,
            'payment_method' => null,
            'total' => $totalPrice,
            'paid_at' => null,
        ]);

        foreach ($bookingItems as $item) {
            $transaction->items()->create([
                'service_id' => $item->service_id,
                'price' => $item->price,
            ]);
        }

        if (in_array($booking->status, ['pending', 'confirmed'], true)) {
            $booking->update(['status' => 'arrived']);
        }

        return Redirect::route('kasir.transactions.receipt', $transaction)->with('status', 'Booking berhasil dikonversi menjadi transaksi.');
    }

    public function settleTransaction(Request $request, Transaction $transaction)
    {
        if ($transaction->kasir_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->only(['payment_method', 'paid_amount']);

        // run validator so we can return structured true/false per-field for AJAX
        $validator = Validator::make($data, [
            'payment_method' => 'required|in:cash,e-wallet,transfer',
            'paid_amount' => 'nullable|numeric|min:0',
        ]);

        $fieldValidity = [
            'payment_method' => ! $validator->errors()->has('payment_method'),
            'paid_amount' => ! $validator->errors()->has('paid_amount'),
        ];

        if ($request->wantsJson()) {
            if ($validator->fails()) {
                return response()->json([
                    'valid' => false,
                    'fields' => $fieldValidity,
                    'errors' => $validator->errors(),
                ], 422);
            }
        } else {
            // for non-AJAX, throw on failure (keeps previous behaviour)
            $validator->validate();
        }

        $paidAmount = null;
        $changeAmount = null;

        if ($data['payment_method'] === 'cash') {
            // extra check: paid_amount must be provided and >= total
            $cashValidator = Validator::make($data, [
                'paid_amount' => ['required', 'numeric', 'min:' . $transaction->total],
            ]);

            if ($request->wantsJson() && $cashValidator->fails()) {
                return response()->json([
                    'valid' => false,
                    'fields' => [
                        'payment_method' => true,
                        'paid_amount' => false,
                    ],
                    'errors' => $cashValidator->errors(),
                ], 422);
            }

            // for non-AJAX, let it validate and throw
            $cashValidator->validate();

            $paidAmount = round($data['paid_amount'], 2);
            $changeAmount = round($paidAmount - $transaction->total, 2);
        } else {
            $paidAmount = $transaction->total;
            $changeAmount = 0;
        }

        $transaction->update([
            'payment_method' => $data['payment_method'],
            'paid_amount' => $paidAmount,
            'change_amount' => $changeAmount,
            'paid_at' => now(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'valid' => true,
                'fields' => [
                    'payment_method' => true,
                    'paid_amount' => true,
                ],
                'transaction' => $transaction->fresh(),
            ]);
        }

        return Redirect::route('kasir.transactions.receipt', $transaction)->with('status', 'Pembayaran berhasil dilunasi.');
    }
}
