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
        return view('Role.Guru.Course.index', compact('courses'));
    }

    public function create()
    {
        return view('Role.Guru.Course.create');
    }

    public function store(Request $request)
    {
        try {
            Log::info('Data sebelum validasi:', $request->all());
    
            $validated = $request->validate([
                "nama_kursus" => 'required|string|max:255|unique:kursuses',
                "password" => 'required|string|min:8|confirmed',
                "image" => 'required|image|mimes:jpeg,png,jpg,gif|max:40960',
            ]);
    
            Log::info('Data setelah validasi:', $validated);
    
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
    
            Log::info('Gambar berhasil disalin ke folder:', ['path' => $imagePath . '/' . $imageName]);
    
            Log::info('Data sebelum menyimpan ke database:', [
                'nama_kursus' => $validated['nama_kursus'],
                'id_guru' => $guru->id_guru,
                'image' => $imageName,
            ]);
    
            $course = kursus::create([
                'nama_kursus' => $validated['nama_kursus'],
                'password' => Hash::make($validated['password']),
                'id_guru' => $guru->id_guru,
                'image' => $imageName,
            ]);
    
            Log::info('Course created successfully:', [
                'course_id' => $course->id,
                'nama_kursus' => $course->nama_kursus,
                'id_guru' => $course->id_guru,
                'image' => $course->image,
            ]);
    
            return redirect()->route('Guru.Course.index')->with('success', 'Course created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating course: ' . $e->getMessage(), [
                'request' => $request->all(),
                'stack' => $e->getTraceAsString(),
            ]);
    
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat membuat course. Silakan coba lagi.']);
        }
    }   

    public function show(string $id)
    {
        $course = kursuses::with('guru')->findOrFail($id);
        return view('Role.Guru.Course.index', compact('course'));
    }

    public function edit(string $id)
    {
        $course = kursus::findOrFail($id);
        return view('Role.Guru.Course.edit', compact('course'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            "nama_kursus" => 'required|string|max:255|unique:kursuses,nama_kursus,' . $id,
            "password" => 'nullable|string|min:8|confirmed',
            "id_guru" => 'required|exists:gurus,id_guru',
        ]);

        $course = kursus::findOrFail($id);

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