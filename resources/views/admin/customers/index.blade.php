@extends('layouts.admin')

@section('title','Data Pelanggan - Klinik Cantik')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-rose-600">Data Pelanggan</h2>
                <p class="mt-2 text-gray-600">Kelola profil pelanggan dan catatan kunjungan.</p>
            </div>
            <a href="{{ route('admin.customers.create') }}" class="bg-pink-500 text-white px-4 py-2 rounded-lg">Tambah Pelanggan</a>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Telepon</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Dibuat</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($customers as $customer)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $customer->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $customer->phone }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $customer->email }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $customer->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                @if($customer->is_member)
                                    <span class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">Member</span>
                                @else
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">Reguler</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right text-sm">
                                <a href="{{ route('admin.customers.edit', $customer) }}" class="text-pink-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="inline-block ml-3" data-confirm="Hapus pelanggan ini?">
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

        <div class="mt-4">{{ $customers->links() }}</div>
    </div>
@endsection

