<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::paginate(10);
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.promotions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:100|unique:promotions,code',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_percent' => 'required|integer|min:0|max:100',
            'active' => 'sometimes|boolean',
        ]);

        $data['active'] = $request->has('active');
        Promotion::create($data);

        return Redirect::route('admin.promotions.index')->with('success', 'Promo berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $promotion = Promotion::findOrFail($id);
        return view('admin.promotions.edit', compact('promotion'));
    }

    public function update(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);

        $data = $request->validate([
            'code' => 'required|string|max:100|unique:promotions,code,' . $promotion->id,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_percent' => 'required|integer|min:0|max:100',
            'active' => 'sometimes|boolean',
        ]);

        $data['active'] = $request->has('active');
        $promotion->update($data);

        return Redirect::route('admin.promotions.index')->with('success', 'Promo berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->delete();

        return Redirect::route('admin.promotions.index')->with('success', 'Promo berhasil dihapus.');
    }
}
