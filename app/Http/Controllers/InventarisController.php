<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query'); // tangkap input search

        $inventaris = Inventaris::query()
            ->when($query, function($q) use ($query) {
                $q->where('nama_barang', 'like', "%{$query}%")
                ->orWhere('id_inventaris', 'like', "%{$query}%");
            })
            ->orderBy('id_inventaris')
            ->get();

        return view('pages.inventaris.index', compact('inventaris', 'query'));
    }


    public function create()
    {
        return view('pages.inventaris.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'       => 'required|string',
            'kondisi'           => 'required',
            'stok'              => 'required|integer|min:0',
            'tanggal_register'  => 'required|date',
            'foto'              => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('inventaris', 'public');
        }

        Inventaris::create($data);


        return redirect()->route('inventaris.index')
            ->with('success', 'Data inventaris berhasil ditambahkan');
    }

    public function show(Inventaris $inventari)
    {
        return view('pages.inventaris.show', compact('inventari'));
    }

    public function edit(Inventaris $inventari)
    {
        return view('pages.inventaris.edit', compact('inventari'));
    }

    public function update(Request $request, Inventaris $inventari)
    {
        $request->validate([
            'nama_barang'       => 'required|string',
            'kondisi'           => 'required',
            'stok'              => 'required|integer|min:0',
            'tanggal_register'  => 'required|date',
            'foto'              => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('inventaris', 'public');
        }

        $inventari->update($data);

        return redirect()->route('inventaris.index')
            ->with('success', 'Data inventaris berhasil diupdate');
    }

    public function destroy(Inventaris $inventari)
    {
        $inventari->delete();

        return redirect()->route('inventaris.index')
            ->with('success', 'Data inventaris berhasil dihapus');
    }
}
