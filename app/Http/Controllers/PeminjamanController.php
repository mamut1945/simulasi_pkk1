<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Models\Inventaris;

class PeminjamanController extends Controller
{

    public function index(Request $request)
    {
        $query = $request->input('query'); // tangkap input search

        $peminjamans = Peminjaman::query()
            ->when($query, function($q) use ($query) {
                $q->where('nama_barang', 'like', "%{$query}%")
                ->orWhere('nama_peminjam', 'like', "%{$query}%")
                ->orWhere('id_inventaris', 'like', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.peminjaman.index', compact('peminjamans', 'query'));
    }


    public function create()
    {
        $inventaris = Inventaris::all(); 
        return view('pages.peminjaman.create', compact('inventaris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_inventaris' => 'required',
            'nama_peminjam' => 'required',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date',
            'status' => 'required',
            'petugas' => 'required',
        ]);

        $inventaris = Inventaris::where('id_inventaris', $request->id_inventaris)->first();
        if (!$inventaris) {
            return redirect()->back()->withErrors(['id_inventaris' => 'Barang tidak ditemukan'])->withInput();
        }

        // Kurangi stok jika status belum dikembalikan
        if ($request->status != 'Sudah Kembali') {
            $inventaris->stok -= 1;
            $inventaris->save();
        }

        Peminjaman::create([
            'id_inventaris' => $request->id_inventaris,
            'nama_barang' => $inventaris->nama_barang,
            'nama_peminjam' => $request->nama_peminjam,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => $request->status,
            'petugas' => $request->petugas,
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Data berhasil disimpan!');
    }

    public function edit(Peminjaman $peminjaman)
    {
        $inventaris = Inventaris::all(); 
        return view('pages.peminjaman.edit', compact('peminjaman', 'inventaris'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'id_inventaris' => 'required',
            'nama_peminjam' => 'required',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date',
            'status' => 'required',
            'petugas' => 'required',
        ]);

        $inventaris = Inventaris::where('id_inventaris', $request->id_inventaris)->first();
        if (!$inventaris) {
            return redirect()->back()->withErrors(['id_inventaris' => 'Barang tidak ditemukan'])->withInput();
        }

        // Logika stok
        if ($peminjaman->status != 'Sudah Kembali' && $request->status == 'Sudah Kembali') {
            // Barang dikembalikan → stok +1
            $inventaris->stok += 1;
            $inventaris->save();
        } elseif ($peminjaman->status == 'Sudah Kembali' && $request->status != 'Sudah Kembali') {
            // Barang dikembalikan ke status Belum Kembali/Proses → stok -1
            $inventaris->stok -= 1;
            $inventaris->save();
        }

        $peminjaman->update([
            'id_inventaris' => $request->id_inventaris,
            'nama_barang' => $inventaris->nama_barang,
            'nama_peminjam' => $request->nama_peminjam,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => $request->status,
            'petugas' => $request->petugas,
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        // Kembalikan stok jika status belum dikembalikan
        if ($peminjaman->status != 'Sudah Kembali') {
            $inventaris = Inventaris::where('id_inventaris', $peminjaman->id_inventaris)->first();
            if ($inventaris) {
                $inventaris->stok += 1;
                $inventaris->save();
            }
        }

        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Data berhasil dihapus!');
    }
}
