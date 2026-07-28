@extends('layouts.admin')

@section('title','Data Promo - Klinik Cantik')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-rose-600">Data Promo</h2>
                <p class="mt-2 text-gray-600">Kelola promo dan diskon untuk pelanggan.</p>
            </div>
            <a href="{{ route('admin.promotions.create') }}" class="bg-pink-500 text-white px-4 py-2 rounded-lg">Tambah Promo</a>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Kode</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Judul</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Diskon</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($promotions as $promotion)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $promotion->code }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $promotion->title }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $promotion->discount_percent }}%</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $promotion->active ? 'Aktif' : 'Tidak Aktif' }}</td>
                            <td class="px-4 py-3 text-right text-sm">
                                <a href="{{ route('admin.promotions.edit', $promotion) }}" class="text-pink-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.promotions.destroy', $promotion) }}" method="POST" class="inline-block ml-3" data-confirm="Hapus promo ini?">
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

        <div class="mt-4">{{ $promotions->links() }}</div>
    </div>
@endsection

