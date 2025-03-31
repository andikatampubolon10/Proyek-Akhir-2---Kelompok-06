<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = Quiz::with(['course', 'user'])->orderBy('id', 'DESC')->get();
        return view('Role.Guru.Course.Quiz.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Role.Guru.Course.Quiz.create');
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
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
        ]);
        $validated['Password'] = Hash::make($validated['Password']);

        Quiz::create($validated);

        return redirect()->route('Guru.Quiz.index')->with('success', 'Quiz created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        return view('Role.Guru.Course.Quiz.index', compact('quiz'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz)
    {
        return view('Role.Guru.Course.Quiz.edit', compact('quiz'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'Password' => 'nullable|string|min:8',
            'Waktu_Mulai' => 'required|date',
            'Waktu_Selesai' => 'required|date|after:Waktu_Mulai',
            'Waktu_Lihat' => 'nullable|date',
            'Nilai' => 'required|integer',
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
        ]);
        if ($request->filled('Password')) {
            $validated['Password'] = Hash::make($validated['Password']);
        } else {
            unset($validated['Password']);
        }

        $quiz->update($validated);

        return redirect()->route('Guru.Quiz.index')->with('success', 'Quiz updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->route('Guru.Quiz.index')->with('success', 'Quiz deleted successfully.');
    }
}