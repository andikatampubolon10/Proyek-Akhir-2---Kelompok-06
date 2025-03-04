<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller {
  public function index()
{
    $courses = Course::all(); // Ambil semua data course dari database
    return view('dashboard', compact('courses'));
}

    public function create()
    {
        return view('course.create-course'); // Sesuaikan dengan nama file
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courses', 'public');
        }

        Course::create([
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'image' => $imagePath
        ]);
        

        return redirect()->route('dashboard')->with('success', 'Course berhasil ditambahkan');
    }
}
