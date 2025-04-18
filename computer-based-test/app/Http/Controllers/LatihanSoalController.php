<?php

namespace App\Http\Controllers;

use App\Models\latihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class LatihanSoalController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            $idUjian = $request->get('id_ujian');  // Mengambil id_ujian dari URL
            $soals = Soal::where('id_', $idUjian)
            ->with(['ujian', 'latihan', 'tipe_soal'])
            ->orderBy('id_soal', 'DESC')
            ->get();
        $user = auth()->user();
        $soals = Soal::all();
        return view('Role.Guru.Latihan.index', compact('latihanSoals'));
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            return view('Role.Guru.Latihan.create');
        }

        /**
         * Store a newly created resource in storage.
         */
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

            // Store the image
            if ($request->hasFile('Image')) {
                $validated['Image'] = $request->file('Image')->store('images/latihan_soals', 'public');
            }

            LatihanSoal::create($validated);

            return redirect()->route('Guru.LatihanSoal.index')->with('success', 'Latihan Soal created successfully.');
        }

        /**
         * Display the specified resource.
         */
        public function show(LatihanSoal $latihanSoal)
        {
            return view('Role.Guru.Latihan.index', compact('latihanSoal'));
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(LatihanSoal $latihanSoal)
        {
            return view('Role.Guru.Latihan.edit', compact('latihanSoal'));
        }

        /**
         * Update the specified resource in storage.
         */
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

            // Store the new image if provided
            if ($request->hasFile('Image')) {
                // Delete the old image if it exists
                if ($latihanSoal->Image) {
                    Storage::disk('public')->delete($latihanSoal->Image);
                }
                $validated['Image'] = $request->file('Image')->store('images/latihan_soals', 'public');
            }

            $latihanSoal->update($validated);

            return redirect()->route('Guru.LatihanSoal.index')->with('success', 'Latihan Soal updated successfully.');
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(LatihanSoal $latihanSoal)
        {
            if ($latihanSoal->Image) {
                Storage::disk('public')->delete($latihanSoal->Image);
            }

            $latihanSoal->delete();

            return redirect()->route('Guru.LatihanSoal.index')->with('success', 'Latihan Soal deleted successfully.');
        }
    }