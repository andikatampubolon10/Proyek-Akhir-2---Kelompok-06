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

    public function create(Request $request)
    {
        $user = auth()->user();

        $id_kursus = $request->query('id_kursus');

        return view('Role.Guru.create', compact('user', 'id_kursus'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                "nama_kursus" => 'required|string|max:20|unique:kursus',
                "password" => 'required|string|min:8|confirmed',
                "image" => 'required|image|mimes:jpeg,png,jpg,gif|max:40960',
            ]);

            $idUser = auth()->user()->id;
            $guru = Guru::where('id_user', $idUser)->first();

            if (!$guru) {
                throw new \Exception('Guru tidak ditemukan untuk pengguna yang sedang login.');
            }

            if (!$request->image->isValid()) {
                throw new \Exception('Gambar yang diupload tidak valid.');
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName); // Menyimpan gambar di folder public/images

            $imageUrl = url('images/' . $imageName); // URL gambar yang bisa diakses dari domain

            $course = Kursus::create([
                'nama_kursus' => $validated['nama_kursus'],
                'password' => Hash::make($validated['password']),
                'id_guru' => $guru->id_guru,
                'image' => $imageName,  // Simpan nama file gambar
                'image_url' => $imageUrl, // Menyimpan URL gambar
            ]);

            return redirect()->route('Guru.Course.index')->with('success', 'Course created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat membuat course. Silakan coba lagi.']);
        }
    }

    public function show(string $id)
    {
        $course = kursus::with('guru')->findOrFail($id);
        return view('Role.Guru.index', compact('course'));
    }

    public function edit(string $id)
    {
        $course = kursus::findOrFail($id);
        $user = auth()->user();
        return view('Role.Guru.edit', compact('user', 'course'));
    }

    public function update(Request $request, string $id_kursus)
    {
        $validated = $request->validate([
            "nama_kursus" => 'required|string|max:30|unique:kursus,nama_kursus,' . $id_kursus . ',id_kursus',
            "image" => 'nullable|image|mimes:jpeg,png,jpg,gif|max:40960',
        ]);

        $course = Kursus::findOrFail($id_kursus);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($course->image) {
                $oldImagePath = public_path('images/' . $course->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Menghapus gambar lama dari server
                }
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName); // Menyimpan gambar di folder public/images

            $imageUrl = url('images/' . $imageName);

            $validated['image'] = $imageName;
            $validated['image_url'] = $imageUrl; // Menyimpan URL gambar baru
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
