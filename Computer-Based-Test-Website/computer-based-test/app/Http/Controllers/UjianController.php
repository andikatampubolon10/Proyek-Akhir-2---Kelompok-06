<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UjianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ujians = Ujian::with(['course', 'user'])->orderBy('id', 'DESC')->get();
        return view('Role.Guru.Course.Ujian.index', compact('ujians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Role.Guru.Course.Ujian.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Password' => 'required|string|min:8',
            'Waktu_Mulai' => 'required|date',
            'Waktu_Selesai' => 'required|date|after:Waktu_Mulai',
            'Waktu_Lihat' => 'nullable|date',
            'Nilai' => 'required|integer',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
        ]);
        $validated['Password'] = Hash::make($validated['Password']);

        if ($request->hasFile('Image')) {
            $validated['Image'] = $request->file('Image')->store('images/ujians', 'public');
        }

        Ujian::create($validated);

        return redirect()->route('Guru.Ujian.index')->with('success', 'Ujian created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ujian $ujian)
    {
        return view('Role.Guru.Course.Ujian.index', compact('ujian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ujian $ujian)
    {
        return view('Role.Guru.Course.Ujian.edit', compact('ujian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ujian $ujian)
    {
        $validated = $request->validate([
            'Password' => 'nullable|string|min:8',
            'Waktu_Mulai' => 'required|date',
            'Waktu_Selesai' => 'required|date|after:Waktu_Mulai',
            'Waktu_Lihat' => 'nullable|date',
            'Nilai' => 'required|integer',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
        ]);
        if ($request->filled('Password')) {
            $validated['Password'] = Hash::make($validated['Password']);
        } else {
            unset($validated['Password']);
        }
        if ($request->hasFile('Image')) {
            // Delete the old image if it exists
            if ($ujian->Image) {
                Storage::disk('public')->delete($ujian->Image);
            }
            $validated['Image'] = $request->file('Image')->store('images/ujians', 'public');
        }

        $ujian->update($validated);

        return redirect()->route('Guru.Ujian.index')->with('success', 'Ujian updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ujian $ujian)
    {
        // Delete the associated image if it exists
        if ($ujian->Image) {
            Storage::disk('public')->delete($ujian->Image);
        }

        $ujian->delete();

        return redirect()->route('Guru.Ujian.index')->with('success', 'Ujian deleted successfully.');
    }
}