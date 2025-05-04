<?php

namespace App\Http\Controllers;

use App\Models\LatihanSoalSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class LatihanSoalSoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $latihanSoalSoals = LatihanSoalSoal::with(['latihanSoal', 'user'])->orderBy('id', 'DESC')->get();
        return view('Role.Guru.Latihan.Soal.index', compact('latihanSoalSoals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('latihan_soal_soals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Soal' => 'required|string',
            'Jawaban' => 'required|string',
            'Grade' => 'required|integer',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latihan_soal_id' => 'required|exists:latihan_soals,id',
            'user_id' => 'required|exists:users,id',
        ]);

        // Store the image if provided
        if ($request->hasFile('Image')) {
            $validated['Image'] = $request->file('Image')->store('images/latihan_soal_soals', 'public');
        }

        LatihanSoalSoal::create($validated);

        return redirect()->route('Guru.LatihanSoalSoal.index')->with('success', 'Latihan Soal Soal created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LatihanSoalSoal $latihanSoalSoal)
    {
        return view('latihan_soal_soals.show', compact('latihanSoalSoal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LatihanSoalSoal $latihanSoalSoal)
    {
        return view('latihan_soal_soals.edit', compact('latihanSoalSoal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LatihanSoalSoal $latihanSoalSoal)
    {
        $validated = $request->validate([
            'Soal' => 'required|string',
            'Jawaban' => 'required|string',
            'Grade' => 'required|integer',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latihan_soal_id' => 'required|exists:latihan_soals,id',
            'user_id' => 'required|exists:users,id',
        ]);

        // Store the new image if provided
        if ($request->hasFile('Image')) {
            // Delete the old image if it exists
            if ($latihanSoalSoal->Image) {
                Storage::disk('public')->delete($latihanSoalSoal->Image);
            }
            $validated['Image'] = $request->file('Image')->store('images/latihan_soal_soals', 'public');
        }

        $latihanSoalSoal->update($validated);

        return redirect()->route('Guru.LatihanSoalSoal.index')->with('success', 'Latihan Soal Soal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LatihanSoalSoal $latihanSoalSoal)
    {
        if ($latihanSoalSoal->Image) {
            Storage::disk('public')->delete($latihanSoalSoal->Image);
        }

        $latihanSoalSoal->delete();

        return redirect()->route('Guru.LatihanSoalSoal.index')->with('success', 'Latihan Soal Soal deleted successfully.');
    }
}