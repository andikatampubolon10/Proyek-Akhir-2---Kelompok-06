<?php

namespace App\Http\Controllers;

use App\Models\QuizSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class QuizSoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizSoals = QuizSoal::with(['quiz', 'user'])->orderBy('id', 'DESC')->get();
        return view('Role.Guru.Course.Quiz.Soal.index', compact('quizSoals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Role.Guru.Course.Quiz.Soal.create');
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
            'quiz_id' => 'required|exists:quizzes,id',
            'user_id' => 'required|exists:users,id',
        ]);

        // Store the image if provided
        if ($request->hasFile('Image')) {
            $validated['Image'] = $request->file('Image')->store('images/quiz_soals', 'public');
        }

        QuizSoal::create($validated);

        return redirect()->route('Guru.QuizSoal.index')->with('success', 'Quiz Soal created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(QuizSoal $quizSoal)
    {
        return view('Role.Guru.Course.Quiz.Soal.index', compact('quizSoal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuizSoal $quizSoal)
    {
        return view('Role.Guru.Course.Quiz.Soal.edit', compact('quizSoal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuizSoal $quizSoal)
    {
        $validated = $request->validate([
            'Soal' => 'required|string',
            'Jawaban' => 'required|string',
            'Grade' => 'required|integer',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quiz_id' => 'required|exists:quizzes,id',
            'user_id' => 'required|exists:users,id',
        ]);
        if ($request->hasFile('Image')) {
            if ($quizSoal->Image) {
                Storage::disk('public')->delete($quizSoal->Image);
            }
            $validated['Image'] = $request->file('Image')->store('images/quiz_soals', 'public');
        }

        $quizSoal->update($validated);

        return redirect()->route('Guru.QuizSoal.index')->with('success', 'Quiz Soal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuizSoal $quizSoal)
    {
        if ($quizSoal->Image) {
            Storage::disk('public')->delete($quizSoal->Image);
        }

        $quizSoal->delete();

        return redirect()->route('Guru.QuizSoal.index')->with('success', 'Quiz Soal deleted successfully.');
    }
}