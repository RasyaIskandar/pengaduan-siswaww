<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class GuruController extends Controller
{
    public function index(): View
    {
        $gurus = Siswa::all();


        return view('guru.index' , compact('gurus'));
    }

    public function store(Request $request)
    {
        $data = Siswa::create([
            'pelapor' => $request->input('pelapor'),
            'terlapor' => $request->input('terlapor'),
            'kelas' => $request->input('kelas'),
            'laporan' => $request->input('laporan'),
            'bukti' => $request->file('bukti')->store('bukti_laporan', 'public'), // Menyimpan file ke storage
            'status' => 'Menunggu...',
        ]);


        return redirect()->route('guru.index')-> with('success', 'Data Berhasil Ditambahkan');
    }
}
