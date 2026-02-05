<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventaris;

class HomeController extends Controller
{
    public function index()
    {
        $inventaris = Inventaris::all(); // ambil semua inventaris
        return view('pages.index', compact('inventaris')); // kirim ke view
    }
}
