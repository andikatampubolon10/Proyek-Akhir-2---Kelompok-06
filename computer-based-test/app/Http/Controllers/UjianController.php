<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use App\Models\Kursus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UjianController extends Controller
{
public function index()
{
    $ujians = Ujian::with(['kursus', 'guru'])->orderBy('id_ujian', 'DESC')->get();
    return view('Role.Guru.Course.Course', compact('ujians'));
}

public function create()
{
    return view('Role.Guru.Course.AddQuestion');
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ujian' => 'required|string|max:255',
            'acak' => 'required|in:Aktif,Tidak Aktif',
            'status_jawaban' => 'required|in:Aktif,Tidak Aktif',
            'grade' => 'required|numeric',
            'Waktu_Mulai' => 'required|date',
            'Waktu_Selesai' => 'required|date|after:Waktu_Mulai',
            'Waktu_Lihat' => 'nullable|date',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_kursus' => 'required|exists:kursuses,id_kursus',
            'id_guru' => 'required|exists:gurus,id_guru',
            'id_tipe_ujian' => 'required|exists:tipe_ujians,id_tipe_ujian',
        ]);

        if ($request->hasFile('Image')) {
            $validated['Image'] = $request->file('Image')->store('images/ujians', 'public');
        }

        Ujian::create($validated);

        return redirect()->route('Guru.Ujian.index')->with('success', 'Ujian created successfully.');
    }

    public function show(Ujian $ujian)
    {
        $course = $ujian->kursus;
        return view('Role.Guru.Course.Ujian.index', compact('ujian', 'course'));
    }

    public function edit(Ujian $ujian)
    {
        return view('Role.Guru.Course.Ujian.edit', compact('ujian'));
    }

    public function update(Request $request, Ujian $ujian)
    {
        $validated = $request->validate([
            'nama_ujian' => 'nullable|string|max:255',
            'acak' => 'nullable|in:Aktif,Tidak Aktif',
            'status_jawaban' => 'nullable|in:Aktif,Tidak Aktif',
            'grade' => 'nullable|numeric',
            'Waktu_Mulai' => 'required|date',
            'Waktu_Selesai' => 'required|date|after:Waktu_Mulai',
            'Waktu_Lihat' => 'nullable|date',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_kursus' => 'required|exists:kursuses,id_kursus',
            'id_guru' => 'required|exists:gurus,id_guru',
            'id_tipe_ujian' => 'required|exists:tipe_ujians,id_tipe_ujian',
        ]);

        if ($request->hasFile('Image')) {
            if ($ujian->Image) {
                Storage::disk('public')->delete($ujian->Image);
            }
            $validated['Image'] = $request->file('Image')->store('images/ujians', 'public');
        }

        $ujian->update($validated);

        return redirect()->route('Guru.Ujian.index')->with('success', 'Ujian updated successfully.');
    }

    public function destroy(Ujian $ujian)
    {
        if ($ujian->Image) {
            Storage::disk('public')->delete($ujian->Image);
        }

        $ujian->delete();

        return redirect()->route('Guru.Ujian.index')->with('success', 'Ujian deleted successfully.');
    }
}