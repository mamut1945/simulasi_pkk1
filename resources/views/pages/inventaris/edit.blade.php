@extends('layouts.app')

@section('title', 'Edit Inventaris')

@section('content')
<div class="flex justify-center mt-10">
    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-xl font-semibold mb-4">Edit Inventaris</h1>

        {{-- error --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('inventaris.update', $inventari->id_inventaris) }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium">Nama Barang</label>
                <input type="text" name="nama_barang"
                    class="w-full border rounded px-3 py-2"
                    value="{{ old('nama_barang', $inventari->nama_barang) }}">
            </div>

            <div>
                <label class="block text-sm font-medium">Kondisi</label>
                <select name="kondisi" class="w-full border rounded px-3 py-2">
                    <option value="Baik" {{ $inventari->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Perbaikan" {{ $inventari->kondisi == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                    <option value="Rusak" {{ $inventari->kondisi == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">Stok</label>
                <input type="number" name="stok"
                    class="w-full border rounded px-3 py-2"
                    value="{{ old('stok', $inventari->stok) }}">
            </div>

            <div>
                <label class="block text-sm font-medium">Tanggal Register</label>
                <input type="date" name="tanggal_register"
                    class="w-full border rounded px-3 py-2"
                    value="{{ old('tanggal_register', $inventari->tanggal_register) }}">
            </div>

            <div>
                <label class="block text-sm font-medium">Foto</label>
                <input type="file" name="foto" class="w-full">

                @if ($inventari->foto)
                    <img src="{{ asset('storage/' . $inventari->foto) }}"
                        class="w-20 h-20 object-cover rounded mt-2">
                @endif
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <a href="{{ route('inventaris.index') }}"
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
