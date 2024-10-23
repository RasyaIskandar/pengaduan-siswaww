<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class SiswaController extends Controller
{
    public function index(): View
    {
        $siswas = Siswa::get();


        return view('siswa.index' , compact('siswas'));

    }

    public function create()
    {
        return view('siswa.create');
    }
    public function store(Request $request)
    {
        // Validasi data input dari form
        $request->validate([
            'pelapor' => 'required|string|max:255',
            'terlapor' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'laporan' => 'required|string',
            'bukti' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048', // Validasi file upload
        ]);
    
        // Simpan data ke database
        $data = Siswa::create([
            'pelapor' => $request->input('pelapor'),
            'terlapor' => $request->input('terlapor'),
            'kelas' => $request->input('kelas'),
            'laporan' => $request->input('laporan'),
            'bukti' => $request->file('bukti')->store('bukti_laporan', 'public'), // Menyimpan file ke storage
            'status' => 'Menunggu...',
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function selesai($id)
    {
        $pengaduan = Siswa::findOrFail($id);
        $pengaduan->status = 'Selesai';
        $pengaduan->save();

        return redirect()->route('siswa.index')->with('success', 'Data Berhasil Diubah');
    }
    
}
