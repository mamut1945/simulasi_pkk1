@extends('layouts.app')

@section('title', 'Data Inventaris')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold">Data peminjaman</h1>

        <div class="flex justify-between items-center mb-4">

            <form action="{{ route('peminjaman.index') }}" method="GET" class="flex gap-2">
                <input type="text" name="query" placeholder="Cari barang / peminjam / id..."
                    value="{{ $query ?? '' }}"
                    class="border px-3 py-2 rounded">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Cari</button>
            </form>
        </div>


        <a href="{{ route('peminjaman.create') }}"
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
                    <th class="border px-3 py-2 text-left">Nama Peminjam</th>
                    <th class="border px-3 py-2 text-left">Tanggal Pinjam</th>
                    <th class="border px-3 py-2 text-left">Tanggal Kembali</th>
                    <th class="border px-3 py-2 text-left">Status</th>
                    <th class="border px-3 py-2 text-center">Petugas</th>
                    <th class="border px-3 py-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjamans as $item)
                    <tr>
                        <td class="border px-3 py-2">{{ $item->id_inventaris }}</td>
                        <td class="border px-3 py-2">{{ $item->nama_barang }}</td>
                        <td class="border px-3 py-2">{{ $item->nama_peminjam }}</td>
                        <td class="border px-3 py-2">{{ $item->tanggal_pinjam }}</td>
                        <td class="border px-3 py-2">{{ $item->tanggal_kembali }}</td>
                        <td class="border px-3 py-2">
                            <form action="{{ route('peminjaman.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id_inventaris" value="{{ $item->id_inventaris }}">
                                <input type="hidden" name="nama_peminjam" value="{{ $item->nama_peminjam }}">
                                <input type="hidden" name="tanggal_pinjam" value="{{ $item->tanggal_pinjam }}">
                                <input type="hidden" name="tanggal_kembali" value="{{ $item->tanggal_kembali }}">
                                <input type="hidden" name="petugas" value="{{ $item->petugas }}">
                                <input type="hidden" name="nama_barang" value="{{ $item->nama_barang }}">

                                <select name="status" onchange="this.form.submit()" class="border rounded px-2 py-1">
                                    <option value="Belum Kembali" {{ $item->status == 'Belum Kembali' ? 'selected' : '' }}>Belum Kembali</option>
                                    <option value="Sudah Kembali" {{ $item->status == 'Sudah Kembali' ? 'selected' : '' }}>Sudah Kembali</option>
                                    <option value="Proses" {{ $item->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                                </select>
                            </form>
                        </td>
                        <td class="border px-3 py-2">{{ $item->petugas }}</td>
                        <td class="border px-3 py-2 text-center flex justify-center gap-2">
                            <a href="{{ route('peminjaman.edit', $item->id) }}"
                                class="text-blue-600 hover:underline">
                                Edit
                            </a>

                            <form action="{{ route('peminjaman.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus data ini?');">
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
