@extends('layouts.app')

@section('title', 'Tambah Inventaris')

@section('content')
<div class="flex justify-center mt-10">
    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-xl font-semibold mb-4">Tambah Inventaris</h1>

        <form action="{{ route('inventaris.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium">Nama Barang</label>
                <input type="text" name="nama_barang"
                    class="w-full border rounded px-3 py-2"
                    value="{{ old('nama_barang') }}">
            </div>

            <div>
                <label class="block text-sm font-medium">Kondisi</label>
                <select name="kondisi" class="w-full border rounded px-3 py-2">
                    <option value="Baik">Baik</option>
                    <option value="Perbaikan">Perbaikan</option>
                    <option value="Rusak">Rusak</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">Stok</label>
                <input type="number" name="stok"
                    class="w-full border rounded px-3 py-2"
                    value="{{ old('stok') }}">
            </div>

            <div>
                <label class="block text-sm font-medium">Tanggal Register</label>
                <input type="date" name="tanggal_register"
                    class="w-full border rounded px-3 py-2"
                    value="{{ old('tanggal_register') }}">
            </div>

            <div>
                <label class="block text-sm font-medium">Foto (opsional)</label>
                <input type="file" name="foto" class="w-full">
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <a href="{{ route('inventaris.index') }}"
                    class="px-4 py-2 bg-gray-300 rounded">
                    Batal
                </a>

                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
