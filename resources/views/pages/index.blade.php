@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="p-6">

    <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Dashboard Inventaris</h1>

    {{-- Alert sukses --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-6 text-center font-medium shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($inventaris as $item)
            <div class="bg-white rounded-xl shadow-lg p-5 flex flex-col justify-between hover:shadow-2xl transition duration-300">
                <div>
                    <h2 class="text-xl font-semibold mb-2 text-gray-800">{{ $item->nama_barang }}</h2>
                    <p class="text-gray-500 mb-1"><strong>ID:</strong> {{ $item->id_inventaris }}</p>
                    <p class="text-gray-500 mb-1"><strong>Kondisi:</strong> 
                        <span class="
                            @if($item->kondisi == 'Baik') text-green-600
                            @elseif($item->kondisi == 'Perbaikan') text-yellow-600
                            @else text-red-600
                            @endif
                            font-semibold
                        ">{{ $item->kondisi }}</span>
                    </p>
                    <p class="text-gray-500 mb-1"><strong>Stok:</strong> 
                        <span class="@if($item->stok < 5) text-red-600 font-bold @else text-gray-700 font-medium @endif">
                            {{ $item->stok }}
                        </span>
                    </p>
                </div>

                <div class="mt-4 flex justify-between items-center">
                    <button 
                        onclick="openModal('{{ $item->id_inventaris }}', '{{ $item->nama_barang }}', '{{ $item->stok }}')"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow">
                        Update Stok
                    </button>
                    @if($item->stok < 5)
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold">Stok Sedikit!</span>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-center col-span-3 text-gray-500 font-medium">Tidak ada data inventaris.</p>
        @endforelse
    </div>
</div>

{{-- Modal Update Stok --}}
<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Update Stok</h2>

        <form id="modalForm" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">ID Inventaris</label>
                <input type="text" id="modal_id" name="id_inventaris" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Barang</label>
                <input type="text" id="modal_nama" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Stok</label>
                <input type="number" id="modal_stok" name="stok" class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Script modal --}}
<script>
function openModal(id, nama, stok) {
    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal_id').value = id;
    document.getElementById('modal_nama').value = nama;
    document.getElementById('modal_stok').value = stok;

    // Set action form
    document.getElementById('modalForm').action = `/inventaris/${id}`;
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}
</script>
@endsection
