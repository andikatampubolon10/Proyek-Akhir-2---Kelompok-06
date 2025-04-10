<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Ujian;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nilais = Nilai::with(['user', 'quiz', 'ujian'])->get();
        return view('nilais.index', compact('nilais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $quizzes = Quiz::all();
        $ujians = Ujian::all();
        return view('nilais.create', compact('users', 'quizzes', 'ujians'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'quiz_id' => 'nullable|exists:quizzes,id',
            'ujian_id' => 'nullable|exists:ujians,id',
            'persentase' => 'required|numeric',
            'nilai_akhir' => 'required|numeric',
        ]);

        Nilai::create($validated);
        return redirect()->route('nilais.index')->with('success', 'Nilai created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Nilai $nilai)
    {
        return view('nilais.show', compact('nilai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nilai $nilai)
    {
        $users = User::all();
        $quizzes = Quiz::all();
        $ujians = Ujian::all();
        return view('nilais.edit', compact('nilai', 'users', 'quizzes', 'ujians'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nilai $nilai)
    {
        // Validasi input
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'quiz_id' => 'nullable|exists:quizzes,id',
            'ujian_id' => 'nullable|exists:ujians,id',
            'persentase' => 'required|numeric',
            'nilai_akhir' => 'required|numeric',
        ]);

        $nilai->update($validated);
        return redirect()->route('nilais.index')->with('success', 'Nilai updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nilai $nilai)
    {
        $nilai->delete();
        return redirect()->route('nilais.index')->with('success', 'Nilai deleted successfully.');
    }
}