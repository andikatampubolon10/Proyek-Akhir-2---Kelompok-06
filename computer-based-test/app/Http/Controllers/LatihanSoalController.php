<?php

namespace App\Http\Controllers;

use App\Models\Latihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class LatihanSoalController extends Controller
{
    public function index()
    {
        $latihanSoals = Latihan::orderBy('id', 'DESC')->get();
        $user = auth()->user();
        
        return view('Role.Guru.Latihan.index', compact('latihanSoals', 'user'));
    }

    public function create()
    {
        return view('Role.Guru.Latihan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Nilai' => 'required|integer',
            'Image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'course_id' => 'required|exists:courses,id',
            'kurikulum_id' => 'required|exists:kurikulums,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($request->hasFile('Image')) {
            $validated['Image'] = $request->file('Image')->store('images/latihan_soals', 'public');
        }

        LatihanSoal::create($validated);

        return redirect()->route('Guru.LatihanSoal.index')->with('success', 'Latihan Soal created successfully.');
    }

    public function show(LatihanSoal $latihanSoal)
    {
        return view('Role.Guru.Latihan.index', compact('latihanSoal'));
    }

    public function edit(LatihanSoal $latihanSoal)
    {
        return view('Role.Guru.Latihan.edit', compact('latihanSoal'));
    }

    public function update(Request $request, LatihanSoal $latihanSoal)
    {
        $validated = $request->validate([
            'Nilai' => 'required|integer',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'course_id' => 'required|exists:courses,id',
            'kurikulum_id' => 'required|exists:kurikulums,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($request->hasFile('Image')) {
            if ($latihanSoal->Image) {
                Storage::disk('public')->delete($latihanSoal->Image);
            }
            $validated['Image'] = $request->file('Image')->store('images/latihan_soals', 'public');
        }

        $latihanSoal->update($validated);

        return redirect()->route('Guru.LatihanSoal.index')->with('success', 'Latihan Soal updated successfully.');
    }

    public function destroy(LatihanSoal $latihanSoal)
    {
        if ($latihanSoal->Image) {
            Storage::disk('public')->delete($latihanSoal->Image);
        }

        $latihanSoal->delete();

        return redirect()->route('Guru.LatihanSoal.index')->with('success', 'Latihan Soal deleted successfully.');
    }
}
