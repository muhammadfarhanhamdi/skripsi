<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|string|max:100',
        ]);

        Service::create($data);

        return Redirect::route('admin.services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|string|max:100',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                $fields = [];
                foreach (array_keys($rules) as $field) {
                    $fields[$field] = ! $validator->errors()->has($field);
                }

                return response()->json([
                    'valid' => false,
                    'fields' => $fields,
                    'errors' => $validator->errors(),
                ], 422);
            }

            return Redirect::back()->withErrors($validator)->withInput();
        }

        try {
            $data = $validator->validated();
            $service->update($data);

            if ($request->wantsJson()) {
                return response()->json([
                    'valid' => true,
                    'message' => 'Layanan berhasil diperbarui.',
                    'service' => $service->fresh(),
                ]);
            }

            return Redirect::route('admin.services.index')->with('success', 'Layanan berhasil diperbarui.');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'valid' => false,
                    'message' => 'Terjadi kesalahan saat memperbarui layanan: ' . $e->getMessage(),
                ], 500);
            }

            return Redirect::back()->with('error', 'Terjadi kesalahan saat memperbarui layanan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return Redirect::route('admin.services.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
