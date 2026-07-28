<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['customer', 'creator', 'items.service'])
            ->latest('booking_date')
            ->latest('booking_time')
            ->paginate(12);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $customers = Customer::where('is_member', 1)->orderBy('name')->get();
        $services = Service::orderBy('name')->get();

        return view('admin.bookings.create', compact('customers', 'services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required', Rule::exists('customers', 'id')->where('is_member', 1)],
            'service_id' => 'required|array|min:1',
            'service_id.*' => 'exists:services,id',
            'booking_date' => 'required|date',
            'booking_time' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,confirmed,arrived,completed,canceled',
        ]);

        $customer = Customer::findOrFail($data['customer_id']);

        $services = Service::whereIn('id', $data['service_id'])->get();
        $primaryService = $services->first();

        $booking = Booking::create([
            'customer_id' => $customer->id,
            'service_id' => $primaryService?->id,
            'created_by' => Auth::id(),
            'booking_date' => $data['booking_date'],
            'booking_time' => $data['booking_time'] ?? null,
            'customer_name' => $customer->name,
            'customer_phone' => $customer->phone,
            'source' => 'whatsapp',
            'status' => $data['status'],
            'notes' => $data['notes'] ?? null,
        ]);

        foreach ($services as $service) {
            $booking->items()->create([
                'service_id' => $service->id,
                'price' => $service->price,
            ]);
        }

        return Redirect::route('admin.bookings.index')->with('success', 'Booking berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $customers = Customer::where('is_member', 1)->orderBy('name')->get();
        $services = Service::orderBy('name')->get();

        return view('admin.bookings.edit', compact('booking', 'customers', 'services'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $data = $request->validate([
            'customer_id' => ['required', Rule::exists('customers', 'id')->where('is_member', 1)],
            'service_id' => 'required|array|min:1',
            'service_id.*' => 'exists:services,id',
            'booking_date' => 'required|date',
            'booking_time' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,confirmed,arrived,completed,canceled',
        ]);

        $customer = Customer::findOrFail($data['customer_id']);
        $services = Service::whereIn('id', $data['service_id'])->get();
        $primaryService = $services->first();

        $booking->update([
            'customer_id' => $customer->id,
            'service_id' => $primaryService?->id,
            'booking_date' => $data['booking_date'],
            'booking_time' => $data['booking_time'] ?? null,
            'customer_name' => $customer->name,
            'customer_phone' => $customer->phone,
            'status' => $data['status'],
            'notes' => $data['notes'] ?? null,
        ]);

        $booking->items()->delete();

        foreach ($services as $service) {
            $booking->items()->create([
                'service_id' => $service->id,
                'price' => $service->price,
            ]);
        }

        return Redirect::route('admin.bookings.index')->with('success', 'Booking berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return Redirect::route('admin.bookings.index')->with('success', 'Booking berhasil dihapus.');
    }
}
