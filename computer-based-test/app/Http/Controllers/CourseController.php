<?php

namespace App\Http\Controllers;

use App\Models\kursus;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class CourseController extends Controller
{
    public function index()
    {
        $courses = kursus::with('guru')->get();
        $user = auth()->user();
        return view('Role.Guru.index', compact('courses', 'user'));
    }

    public function create()
    {
        $user = auth()->user();
        return view('Role.Guru.create', compact('user'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                "nama_kursus" => 'required|string|max:255|unique:kursus',
                "password" => 'required|string|min:8|confirmed',
                "image" => 'required|image|mimes:jpeg,png,jpg,gif|max:40960',
                "persentase_kuis" => 'required|numeric|min:0|max:100',
                "persentase_ujian" => 'required|numeric|min:0|max:100',
            ]);
    
            $totalPersentase = $validated['persentase_kuis'] + $validated['persentase_ujian'];
    
            if ($totalPersentase > 100) {
                return redirect()->back()->withErrors(['error' => 'Total persentase kuis dan ujian tidak boleh lebih dari 100%.']);
            }
    
            $idUser   = auth()->user()->id;
            $guru = Guru::where('id_user', $idUser )->first();
    
            if (!$guru) {
                throw new \Exception('Guru tidak ditemukan untuk pengguna yang sedang login.');
            }
    
            if (!$request->image->isValid()) {
                throw new \Exception('Gambar yang diupload tidak valid.');
            }
    
            $imagePath = public_path('images');
            if (!is_dir($imagePath)) {
                mkdir($imagePath, 0755, true);
            }
    
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move($imagePath, $imageName);
    
            $course = Kursus::create([
                'nama_kursus' => $validated['nama_kursus'],
                'password' => Hash::make($validated['password']),
                'id_guru' => $guru->id_guru,
                'image' => $imageName,
                'persentase_kuis' => $validated['persentase_kuis'],
                'persentase_ujian' => $validated['persentase_ujian'],
            ]);
    
            return redirect()->route('Guru.Course.index')->with('success', 'Course created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat membuat course. Silakan coba lagi.']);
        }
    }

    public function show(string $id)
    {
        $course = kursuses::with('guru')->findOrFail($id);
        return view('Role.Guru.index', compact('course'));
    }

    public function edit(string $id)
    {
        $course = kursus::findOrFail($id);
        return view('Role.Guru.edit', compact('course'));
    }
    
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            "nama_kursus" => 'required|string|max:255|unique:kursus,nama_kursus,' . $id,
            "password" => 'nullable|string|min:8|confirmed',
            "persentase_kuis" => 'required|numeric|min:0|max:100',
            "persentase_ujian" => 'required|numeric|min:0|max:100',
        ]);
    
        $totalPersentase = $validated['persentase_kuis'] + $validated['persentase_ujian'];
    
        if ($totalPersentase > 100) {
            return redirect()->back()->withErrors(['error' => 'Total persentase kuis dan ujian tidak boleh lebih dari 100%.']);
        }
    
        $course = Kursus::findOrFail($id);
    
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
    
        $course->update($validated);
    
        return redirect()->route('Guru.Course.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(string $id)
    {
        $course = kursus::findOrFail($id);
        $course->delete();

        return redirect()->route('Guru.Course.index')->with('success', 'Course deleted successfully.');
    }
}