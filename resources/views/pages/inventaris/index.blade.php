@extends('layouts.app')

@section('title', 'Data Inventaris')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold">Data Inventaris</h1>

        <form action="{{ route('inventaris.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="query"
                placeholder="Cari nama atau ID..."
                value="{{ $query ?? '' }}"
                class="border rounded px-3 py-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                Cari
            </button>
        </form>

        <a href="{{ route('inventaris.create') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded">
            + Tambah Inventaris
        </a>
    </div>

    {{-- alert sukses --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2 text-left">ID</th>
                    <th class="border px-3 py-2 text-left">Nama Barang</th>
                    <th class="border px-3 py-2 text-left">Kondisi</th>
                    <th class="border px-3 py-2 text-left">Stok</th>
                    <th class="border px-3 py-2 text-left">Tanggal</th>
                    <th class="border px-3 py-2 text-left">Foto</th>
                    <th class="border px-3 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($inventaris as $item)
                    <tr>
                        <td class="border px-3 py-2">{{ $item->id_inventaris }}</td>
                        <td class="border px-3 py-2">{{ $item->nama_barang }}</td>
                        <td class="border px-3 py-2">{{ $item->kondisi }}</td>
                        <td class="border px-3 py-2">{{ $item->stok }}</td>
                        <td class="border px-3 py-2">
                            {{ \Carbon\Carbon::parse($item->tanggal_register)->format('d-m-Y') }}
                        </td>
                        <td class="border px-3 py-2">
                            @if ($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}"
                                    class="w-16 h-16 object-cover rounded">
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="border px-3 py-2 text-center flex justify-center gap-2">
                            <a href="{{ route('inventaris.edit', $item->id_inventaris) }}"
                                class="text-blue-600 hover:underline">
                                Edit
                            </a>

                            <form action="{{ route('inventaris.destroy', $item->id_inventaris) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">
                            Data inventaris belum ada
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
