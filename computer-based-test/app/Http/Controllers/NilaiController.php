<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Kursus;
use App\Models\Siswa;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index()
    {
        $courses = kursus::with('guru')->get();
        $user = auth()->user();
        return view('Role.Guru.Nilai.index', compact('courses', 'user'));
    }

    // Menampilkan form untuk membuat nilai baru
    public function create()
    {
        $user = auth()->user();
        return view('Role.Guru.Nilai.create', compact('user'));
    }

    // Menyimpan nilai baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_kursus' => 'required|exists:kursus,id_kursus',
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'nilai_kuis' => 'required|numeric|min:0|max:100',
            'nilai_ujian' => 'required|numeric|min:0|max:100',
        ]);

        $kursus = Kursus::findOrFail($validated['id_kursus']);
        $persentaseKuis = $kursus->persentase_kuis;
        $persentaseUjian = $kursus->persentase_ujian;

        $nilaiTotal = ($validated['nilai_kuis'] * $persentaseKuis / 100) +
                      ($validated['nilai_ujian'] * $persentaseUjian / 100);

        Nilai::create([
            'id_kursus' => $validated['id_kursus'],
            'id_siswa' => $validated['id_siswa'],
            'nilai_kuis' => $validated['nilai_kuis'],
            'nilai_ujian' => $validated['nilai_ujian'],
            'nilai_total' => $nilaiTotal,
        ]);

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil disimpan.');
    }

    // Menampilkan form untuk mengedit nilai
    public function edit($id)
    {
        $nilai = Nilai::findOrFail($id);
        $kursus = Kursus::all();
        $siswa = Siswa::all();
        return view('nilai.edit', compact('nilai', 'kursus', 'siswa'));
    }

    // Memperbarui nilai
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_kursus' => 'required|exists:kursus,id_kursus',
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'nilai_kuis' => 'required|numeric|min:0|max:100',
            'nilai_ujian' => 'required|numeric|min:0|max:100',
        ]);

        $kursus = Kursus::findOrFail($validated['id_kursus']);
        $persentaseKuis = $kursus->persentase_kuis;
        $persentaseUjian = $kursus->persentase_ujian;

        $nilaiTotal = ($validated['nilai_kuis'] * $persentaseKuis / 100) +
                      ($validated['nilai_ujian'] * $persentaseUjian / 100);

        $nilai = Nilai::findOrFail($id);
        $nilai->update([
            'id_kursus' => $validated['id_kursus'],
            'id_siswa' => $validated['id_siswa'],
            'nilai_kuis' => $validated['nilai_kuis'],
            'nilai_ujian' => $validated['nilai_ujian'],
            'nilai_total' => $nilaiTotal,
        ]);

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil diperbarui.');
    }

    // Menghapus nilai
    public function destroy($id)
    {
        $nilai = Nilai::findOrFail($id);
        $nilai->delete();

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil dihapus.');
    }
}