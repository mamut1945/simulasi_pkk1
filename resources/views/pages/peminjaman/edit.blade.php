@extends('layouts.app')

@section('title', 'Edit Peminjaman')

@section('content')
<div class="flex justify-center mt-10">
    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-xl font-semibold mb-4">Edit Peminjaman</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Pilih Barang --}}
            <div>
                <label class="block text-sm font-medium">Barang</label>
                <select name="id_inventaris" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach ($inventaris as $item)
                        @php
                            $isBorrowed = $item->peminjamans()->where('status', 'Belum Kembali')->exists();
                        @endphp
                        {{-- Tampilkan barang yang stok > 0 atau barang yang sedang dipinjam ini sendiri --}}
                        @if (!$isBorrowed || $peminjaman->id_inventaris == $item->id_inventaris)
                            <option value="{{ $item->id_inventaris }}"
                                {{ $peminjaman->id_inventaris == $item->id_inventaris ? 'selected' : '' }}>
                                {{ $item->nama_barang }} (Stok: {{ $item->stok }})
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">Nama Peminjam</label>
                <input type="text" name="nama_peminjam"
                    class="w-full border rounded px-3 py-2"
                    value="{{ old('nama_peminjam', $peminjaman->nama_peminjam) }}" required>
            </div>

            <div>
                <label class="block text-sm font-medium">Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam"
                    class="w-full border rounded px-3 py-2"
                    value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam) }}" required>
            </div>

            <div>
                <label class="block text-sm font-medium">Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali"
                    class="w-full border rounded px-3 py-2"
                    value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali) }}">
            </div>

            <div>
                <label class="block text-sm font-medium">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2" required>
                    <option value="Belum Kembali" {{ $peminjaman->status == 'Belum Kembali' ? 'selected' : '' }}>Belum Kembali</option>
                    <option value="Sudah Kembali" {{ $peminjaman->status == 'Sudah Kembali' ? 'selected' : '' }}>Sudah Kembali</option>
                    <option value="Proses" {{ $peminjaman->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">Petugas</label>
                <input type="text" name="petugas"
                    class="w-full border rounded px-3 py-2"
                    value="{{ old('petugas', $peminjaman->petugas) }}" required>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <a href="{{ route('peminjaman.index') }}"
                    class="px-4 py-2 bg-gray-300 rounded">
                    Batal
                </a>

                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
