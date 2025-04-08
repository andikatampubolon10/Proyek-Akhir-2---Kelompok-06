<?php

namespace App\Http\Controllers;

use App\Models\UjianSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UjianSoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ujianSoals = UjianSoal::with(['ujian', 'user'])->orderBy('id', 'DESC')->get();
        return view('Role.Guru.Course.Ujian.Soal.index', compact('ujianSoals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Role.Guru.Course.Ujian.Soal.create');
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
            'ujian_id' => 'required|exists:ujians,id',
            'user_id' => 'required|exists:users,id',
        ]);
        if ($request->hasFile('Image')) {
            $validated['Image'] = $request->file('Image')->store('images/ujian_soals', 'public');
        }

        UjianSoal::create($validated);

        return redirect()->route('Guru.UjianSoal.index')->with('success', 'Ujian Soal created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(UjianSoal $ujianSoal)
    {
        return view('Role.Guru.Course.Ujian.Soal.index', compact('ujianSoal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UjianSoal $ujianSoal)
    {
        return view('Role.Guru.Course.Ujian.Soal.edit', compact('ujianSoal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UjianSoal $ujianSoal)
    {
        $validated = $request->validate([
            'Soal' => 'required|string',
            'Jawaban' => 'required|string',
            'Grade' => 'required|integer',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ujian_id' => 'required|exists:ujians,id',
            'user_id' => 'required|exists:users,id',
        ]);

        // Store the new image if provided
        if ($request->hasFile('Image')) {
            // Delete the old image if it exists
            if ($ujianSoal->Image) {
                Storage::disk('public')->delete($ujianSoal->Image);
            }
            $validated['Image'] = $request->file('Image')->store('images/ujian_soals', 'public');
        }

        $ujianSoal->update($validated);

        return redirect()->route('Guru.UjianSoal.index')->with('success', 'Ujian Soal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UjianSoal $ujianSoal)
    {
        // Delete the associated image if it exists
        if ($ujianSoal->Image) {
            Storage::disk('public')->delete($ujianSoal->Image);
        }

        $ujianSoal->delete();

        return redirect()->route('ujian_soals.index')->with('success', 'Ujian Soal deleted successfully.');
    }
}