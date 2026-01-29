<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lokasi;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lokasis = Lokasi::where('aktif', 'y')->get();
        return view('pages.admin.lokasi.index', compact('lokasis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $payload = $request->validate([
            'nama_lokasi' => 'required|string|max:255',
        ]);

        if (!isset($payload['nama_lokasi'])) {
            return redirect()->route('lokasis.index')->with('error', 'Nama lokasi wajib diisi.');
        }

        Lokasi::create([
            'nama_lokasi' => $payload['nama_lokasi'],
        ]);

        return redirect()->route('admin.lokasis.index')->with('success', 'lokasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lokasis = Lokasi::all();

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        {
            $lokasi = Lokasi::findOrFail($id);
            return redirect()->route('admin.lokasis.index', compact('lokasi'))->with('success', 'lokasi berhasil dipindah ke sampah');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payload = $request->validate([
            'nama_lokasi' => 'required|string|max:255',
        ]);

        if (!isset($payload['nama_lokasi'])) {
            return redirect()->route('lokasis.index')->with('error', 'Nama lokasi wajib diisi.');
        }

        $lokasi = Lokasi::findOrFail($id);
        $lokasi->nama_lokasi = $payload['nama_lokasi'];
        $lokasi->save();

        return redirect()->route('admin.lokasis.index')->with('success', 'lokasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lokasi = Lokasi::findOrFail($id);
        $lokasi->aktif = 'N';
        $lokasi->save();
        return redirect()->route('admin.lokasis.index')->with('success', 'Lokasi berhasil dihapus.');
    }
}
