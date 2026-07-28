<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class KasirController extends Controller
{
    public function index()
    {
        $kasirs = User::where('role', 'kasir')->paginate(10);
        return view('admin.kasirs.index', compact('kasirs'));
    }

    public function create()
    {
        return view('admin.kasirs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'kasir',
        ]);

        return Redirect::route('admin.kasirs.index')->with('success', 'Akun kasir berhasil dibuat.');
    }

    public function edit($id)
    {
        $kasir = User::where('role', 'kasir')->findOrFail($id);
        return view('admin.kasirs.edit', compact('kasir'));
    }

    public function update(Request $request, $id)
    {
        $kasir = User::where('role', 'kasir')->findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $kasir->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $kasir->name = $data['name'];
        $kasir->email = $data['email'];

        if (!empty($data['password'])) {
            $kasir->password = Hash::make($data['password']);
        }

        $kasir->save();

        return Redirect::route('admin.kasirs.index')->with('success', 'Data kasir berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kasir = User::where('role', 'kasir')->findOrFail($id);
        $kasir->delete();

        return Redirect::route('admin.kasirs.index')->with('success', 'Kasir berhasil dihapus.');
    }
}
