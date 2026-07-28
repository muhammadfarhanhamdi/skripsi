@extends('layouts.admin')

@section('title','Data Layanan - Klinik Cantik')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-rose-600">Data Layanan</h2>
                <p class="mt-2 text-gray-600">Kelola treatment dan harga layanan.</p>
            </div>
            <a href="{{ route('admin.services.create') }}" class="bg-pink-500 text-white px-4 py-2 rounded-lg">Tambah Layanan</a>
        </div>

        @include('shared.alert', ['type' => 'success', 'message' => session('success')])
        @if(session('error'))
            @include('shared.alert', ['type' => 'error', 'message' => session('error')])
        @endif

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Harga</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Durasi</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($services as $service)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $service->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $service->duration }}</td>
                            <td class="px-4 py-3 text-right text-sm">
                                <a href="{{ route('admin.services.edit', $service) }}" class="text-pink-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline-block ml-3" data-confirm="Hapus layanan ini?">
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

        <div class="mt-4">{{ $services->links() }}</div>
    </div>
@endsection

