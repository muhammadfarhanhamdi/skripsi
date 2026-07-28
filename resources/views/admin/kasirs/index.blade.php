@extends('layouts.admin')

@section('title','Data Kasir - Klinik Cantik')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-rose-600">Data Kasir</h2>
                <p class="mt-2 text-gray-600">Kelola akun kasir yang aktif di sistem.</p>
            </div>
            <a href="{{ route('admin.kasirs.create') }}" class="bg-pink-500 text-white px-4 py-2 rounded-lg">Tambah Kasir</a>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Dibuat</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($kasirs as $kasir)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $kasir->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $kasir->email }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $kasir->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-right text-sm">
                                <a href="{{ route('admin.kasirs.edit', $kasir) }}" class="text-pink-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.kasirs.destroy', $kasir) }}" method="POST" class="inline-block ml-3" data-confirm="Hapus kasir ini?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $kasirs->links() }}</div>
    </div>
@endsection

