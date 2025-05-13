<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\User;
use App\Models\Ujian;
use App\Models\Guru;
use App\Models\latihan;
use App\Models\tipe_ujian;
use App\Models\JawabanSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SoalController extends Controller
{
    public function index(Request $request)
    {
        $idUjian = $request->get('id_ujian');
        $idLatihan = $request->get('id_latihan');

        $soals = null;

        if ($idUjian) {
            $soals = Soal::where('id_ujian', $idUjian)
                ->with(['ujian', 'latihan', 'tipe_soal'])
                ->orderBy('id_soal', 'DESC')
                ->get();
        } elseif ($idLatihan) {
            $soals = Soal::where('id_latihan', $idLatihan)
                ->with(['latihan', 'tipe_soal'])
                ->orderBy('id_soal', 'DESC')
                ->get();
        }

        // Ambil data user yang sedang login
        $user = auth()->user();

        // Kembalikan ke view dengan data soal yang sudah difilter
        return view('Role.Guru.Course.Soal.index', compact('soals', 'user', 'idUjian', 'idLatihan'));
    }

    public function create(Request $request)
    {
        $type = $request->query('type');
        $users = auth()->user();
        $latihan = latihan::all();

        switch ($type) {
            case 'pilgan':
                return view('Role.Guru.Course.Soal.pilber', compact('users', 'latihan'));
            case 'truefalse':
                return view('Role.Guru.Course.Soal.truefalse', compact('users', 'latihan'));
            case 'essay':
                return view('Role.Guru.Course.Soal.essai', compact('users', 'latihan'));
            default:
                return redirect()->route('Guru.Soal.index')->with('error', 'Tipe soal tidak valid.');
        }
    }

    public function store(Request $request)
    {
        Log::info('Menerima request untuk membuat soal.');

        $validated = $request->validate([
            'soal' => 'required|string|max:40',
            'id_tipe_soal' => 'required|exists:tipe_soal,id_tipe_soal',
            'id_latihan' => 'nullable|exists:latihan,id_latihan', // Untuk latihan
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jawaban_1' => 'nullable|string|max:30',
            'jawaban_2' => 'nullable|string|max:30',
            'jawaban_3' => 'nullable|string|max:30',
            'jawaban_4' => 'nullable|string|max:30',
            'jawaban_5' => 'nullable|string|max:30',
            'correct_answer' => 'required|string',
        ]);

        Log::info('Validasi berhasil untuk soal.', ['validated_data' => $validated]);

        $idUjian = null;
        $idLatihan = $validated['id_latihan'] ?? null;

        $users = Auth::user();

        if (!$users) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $guru = Guru::where('id_user', auth()->user()->id)->first();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Ensure the images folder exists
            $imagePath = public_path('images');
            if (!is_dir($imagePath)) {
                mkdir($imagePath, 0755, true);
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move($imagePath, $imageName);

            $imageUrl = url('images/' . $imageName);
        } else {
            $imageName = null;
            $imageUrl = null;
        }

        $kursus = $guru->kursus()->first();

        if ($idLatihan) {
            $latihan = Latihan::findOrFail($idLatihan);

            $soal = Soal::create([
                'soal' => $validated['soal'],
                'image' => $imageName,
                'id_tipe_soal' => $validated['id_tipe_soal'],
                'id_latihan' => $idLatihan,
                'image_url' => $imageUrl,
            ]);

            $jumlahSoalLatihan = Soal::where('id_latihan', $idLatihan)->count();

            $nilaiPerSoalLatihan = $jumlahSoalLatihan > 0 ? round(100 / $jumlahSoalLatihan, 2) : 0;

            $soal->update(['nilai_per_soal' => $nilaiPerSoalLatihan]);
            Soal::where('id_latihan', $idLatihan)->update(['nilai_per_soal' => $nilaiPerSoalLatihan]);

            Log::info('Soal latihan berhasil dibuat.', ['soal_id' => $soal->id_soal]);
        } else {
            $ujian = $kursus->ujian()->first();
            $idUjian = $ujian ? $ujian->id_ujian : null;

            $soal = Soal::create([
                'soal' => $validated['soal'],
                'image' => $imageName,
                'image_url' => $imageUrl,
                'id_ujian' => $idUjian, // If there is an ujian, store id_ujian
                'id_tipe_soal' => $validated['id_tipe_soal'],
                'id_latihan' => null, // Soal for ujian is not related to latihan
            ]);

            $jumlahSoal = Soal::where('id_ujian', $idUjian)->count();

            $nilaiPerSoal = $jumlahSoal > 0 ? round(100 / $jumlahSoal, 2) : 0;

            $soal->update(['nilai_per_soal' => $nilaiPerSoal]);
            Soal::where('id_ujian', $idUjian)->update(['nilai_per_soal' => $nilaiPerSoal]);

            Log::info('Soal ujian berhasil dibuat.', ['soal_id' => $soal->id_soal]);
        }

        $jawaban_data = [];
        if ($validated['id_tipe_soal'] == 1) {
            $jawaban_data = [
                ['jawaban' => $validated['jawaban_1'], 'benar' => $validated['correct_answer'] === 'jawaban_1', 'id_tipe_soal' => $validated['id_tipe_soal']],
                ['jawaban' => $validated['jawaban_2'], 'benar' => $validated['correct_answer'] === 'jawaban_2', 'id_tipe_soal' => $validated['id_tipe_soal']],
                ['jawaban' => $validated['jawaban_3'], 'benar' => $validated['correct_answer'] === 'jawaban_3', 'id_tipe_soal' => $validated['id_tipe_soal']],
                ['jawaban' => $validated['jawaban_4'], 'benar' => $validated['correct_answer'] === 'jawaban_4', 'id_tipe_soal' => $validated['id_tipe_soal']],
                ['jawaban' => $validated['jawaban_5'], 'benar' => $validated['correct_answer'] === 'jawaban_5', 'id_tipe_soal' => $validated['id_tipe_soal']],
            ];
        } else if ($validated['id_tipe_soal'] == 2) {
            $jawaban_data = [
                ['jawaban' => $validated['jawaban_1'], 'benar' => $validated['correct_answer'] === 'jawaban_1', 'id_tipe_soal' => $validated['id_tipe_soal']],
                ['jawaban' => $validated['jawaban_2'], 'benar' => $validated['correct_answer'] === 'jawaban_2', 'id_tipe_soal' => $validated['id_tipe_soal']],
            ];
        } else if ($validated['id_tipe_soal'] == 3) {
            $jawaban_data = [
                ['jawaban' => $validated['correct_answer'], 'benar' => true, 'id_tipe_soal' => $validated['id_tipe_soal']],
            ];
        }

        $soal->jawaban_soal()->createMany($jawaban_data);

        if ($idUjian) {
            return redirect()->route('Guru.Soal.index', ['id_ujian' => $idUjian])->with('success', 'Soal berhasil dibuat.');
        }

        return redirect()->route('Guru.Latihan.index')->with('success', 'Soal latihan berhasil dibuat.');
    }

    public function show(Soal $soal)
    {
        return view('Role.Guru.Course.Soal.index', compact('soal'));
    }

    public function edit(Request $request, $id_soal)
    {

        // Ambil soal berdasarkan ID
        $soal = Soal::findOrFail($id_soal);

        $user = auth()->user();

        $latihan = latihan::all();

        // Cek tipe soal dan arahkan ke view yang sesuai
        switch ($soal->id_tipe_soal) {
            case 1:
                // Tipe soal 1, arahkan ke view untuk tipe soal 1
                return view('Role.Guru.Course.Soal.pilberEdit', compact('soal', 'user', 'latihan'));
            case 2:
                // Tipe soal 2, arahkan ke view untuk tipe soal 2
                return view('Role.Guru.Course.Soal.truefalseEdit', compact('soal', 'user', 'latihan'));
            case 3:
                // Tipe soal 3, arahkan ke view untuk tipe soal 3
                return view('Role.Guru.Course.Soal.essaiEdit', compact('soal', 'user', 'latihan'));
            default:
                // Jika tipe soal tidak dikenali, arahkan ke view default atau error
                return redirect()->route('Guru.Soal.index')->with('error', 'Tipe soal tidak dikenal');
        }
    }

    public function preview(Request $request, $id_soal)
    {
        $soal = Soal::findOrFail($id_soal);

        $user = auth()->user();

        switch ($soal->id_tipe_soal) {
            case 1: // Pilihan Ganda
                return view('Role.Guru.Course.Soal.pilberPreview', compact('soal', 'user'));
            case 2: // True/False
                return view('Role.Guru.Course.Soal.truefalsePreview', compact('soal', 'user'));
            case 3: // Essay
                return view('Role.Guru.Course.Soal.essaiPreview', compact('soal', 'user'));
            default:
                return redirect()->route('Guru.Soal.index')->with('error', 'Tipe soal tidak dikenal');
        }
    }

    public function update(Request $request, $id_soal)
    {
        Log::info('Menerima request untuk memperbarui soal.');

        $validated = $request->validate([
            'soal' => 'required|string|max:40',
            'id_tipe_soal' => 'required|exists:tipe_soal,id_tipe_soal', // Pastikan tipe soal valid
            'id_latihan' => 'nullable|exists:latihan,id_latihan', // Jika ada id_latihan
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jawaban_1' => 'required|string|max:30',
            'jawaban_2' => 'nullable|string|max:30',
            'jawaban_3' => 'nullable|string|max:30',
            'jawaban_4' => 'nullable|string|max:30',
            'jawaban_5' => 'nullable|string|max:30',
            'correct_answer' => 'required|string',
        ]);

        $soal = Soal::findOrFail($id_soal);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = public_path('images');
            if (!is_dir($imagePath)) {
                mkdir($imagePath, 0755, true);  // Pastikan folder images ada
            }

            if ($soal->image) {
                $oldImagePath = public_path('images/' . $soal->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);  // Hapus gambar lama
                }
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move($imagePath, $imageName);

            $imageUrl = url('images/' . $imageName);  

            $soal->image = $imageName;
            $soal->image_url = $imageUrl;  
        }

        $soal->update([
            'soal' => $validated['soal'],
            'image' => $soal->image ?? $soal->image, // Jika ada gambar baru, simpan nama gambar baru
            'image_url' => $soal->image_url ?? $soal->image_url, // Jika ada gambar baru, simpan URL gambar baru
            'id_tipe_soal' => $validated['id_tipe_soal'],
            'id_latihan' => $validated['id_latihan'] ?? $soal->id_latihan,
        ]);

        Log::info('Soal berhasil diperbarui.', ['soal_id' => $soal->id_soal]);

        $jawaban_data = [];
        if ($validated['id_tipe_soal'] == 1) { // Pilihan Ganda
            $jawaban_data = [
                ['jawaban' => $validated['jawaban_1'], 'benar' => $validated['correct_answer'] === 'jawaban_1', 'id_soal' => $soal->id_soal, 'id_tipe_soal' => $validated['id_tipe_soal']],
                ['jawaban' => $validated['jawaban_2'], 'benar' => $validated['correct_answer'] === 'jawaban_2', 'id_soal' => $soal->id_soal, 'id_tipe_soal' => $validated['id_tipe_soal']],
                ['jawaban' => $validated['jawaban_3'], 'benar' => $validated['correct_answer'] === 'jawaban_3', 'id_soal' => $soal->id_soal, 'id_tipe_soal' => $validated['id_tipe_soal']],
                ['jawaban' => $validated['jawaban_4'], 'benar' => $validated['correct_answer'] === 'jawaban_4', 'id_soal' => $soal->id_soal, 'id_tipe_soal' => $validated['id_tipe_soal']],
                ['jawaban' => $validated['jawaban_5'], 'benar' => $validated['correct_answer'] === 'jawaban_5', 'id_soal' => $soal->id_soal, 'id_tipe_soal' => $validated['id_tipe_soal']],
            ];
        } elseif ($validated['id_tipe_soal'] == 2) { // Benar/Salah
            $jawaban_data = [
                ['jawaban' => $validated['jawaban_1'], 'benar' => $validated['correct_answer'] === 'jawaban_1', 'id_soal' => $soal->id_soal, 'id_tipe_soal' => $validated['id_tipe_soal']],
                ['jawaban' => $validated['jawaban_2'], 'benar' => $validated['correct_answer'] === 'jawaban_2', 'id_soal' => $soal->id_soal, 'id_tipe_soal' => $validated['id_tipe_soal']],
            ];
        } elseif ($validated['id_tipe_soal'] == 3) { // Esai
            $jawaban_data = [
                ['jawaban' => $validated['jawaban_1'], 'benar' => true, 'id_soal' => $soal->id_soal, 'id_tipe_soal' => $validated['id_tipe_soal']],
            ];
        }

        $soal->jawaban_soal()->delete(); // Menghapus jawaban lama
        $soal->jawaban_soal()->createMany($jawaban_data); // Menyimpan jawaban baru

        Log::info('Jawaban berhasil disimpan untuk soal.', ['soal_id' => $soal->id_soal]);

        if ($soal->id_latihan) {
            $jumlahSoalLatihan = Soal::where('id_latihan', $soal->id_latihan)->count();
            $nilaiPerSoalLatihan = $jumlahSoalLatihan > 0 ? 100 / $jumlahSoalLatihan : 0;
            $soal->update(['nilai_per_soal' => $nilaiPerSoalLatihan]);

            Soal::where('id_latihan', $soal->id_latihan)->update(['nilai_per_soal' => $nilaiPerSoalLatihan]);
        } elseif ($soal->id_ujian) {
            $jumlahSoal = Soal::where('id_ujian', $soal->id_ujian)->count();
            $nilaiPerSoal = $jumlahSoal > 0 ? $soal->ujian->grade / $jumlahSoal : 0;
            $soal->update(['nilai_per_soal' => $nilaiPerSoal]);

            Soal::where('id_ujian', $soal->id_ujian)->update(['nilai_per_soal' => $nilaiPerSoal]);
        }

        return redirect()->route('Guru.Soal.index', ['id_ujian' => $soal->id_ujian ?? null, 'id_latihan' => $soal->id_latihan ?? null])->with('success', 'Soal berhasil diperbarui.');
    }

    public function destroy(Request $request, $id_soal)
    {
        try {
            // Cari soal berdasarkan id_soal
            $soal = Soal::findOrFail($id_soal); // Menemukan soal berdasarkan id_soal

            // Simpan id_ujian atau id_latihan untuk redirect
            $idUjian = $soal->id_ujian;
            $idLatihan = $soal->id_latihan;

            // Proses penghapusan soal
            if ($soal->image) {
                Storage::disk('public')->delete($soal->image); // Hapus gambar jika ada
            }

            // Hapus soal
            $soal->delete();

            // Mengupdate nilai per soal setelah penghapusan
            if ($idLatihan) {
                // Jika soal terkait latihan, update nilai per soal untuk latihan
                $this->updateNilaiPerSoalLatihan($idLatihan);
            } elseif ($idUjian) {
                // Jika soal terkait ujian, update nilai per soal untuk ujian
                $this->updateNilaiPerSoalUjian($idUjian);
            }

            // Redirect sesuai dengan id_ujian atau id_latihan
            if ($idLatihan) {
                // Redirect ke halaman soal latihan jika soal tersebut terkait latihan
                return redirect()->route('Guru.Soal.index', ['id_latihan' => $idLatihan])->with('success', 'Soal latihan berhasil dihapus dan nilai per soal diperbarui.');
            } elseif ($idUjian) {
                // Redirect ke halaman soal ujian jika soal tersebut terkait ujian
                return redirect()->route('Guru.Soal.index', ['id_ujian' => $idUjian])->with('success', 'Soal ujian berhasil dihapus dan nilai per soal diperbarui.');
            }

            // Jika tidak ada id_ujian atau id_latihan, kembalikan ke halaman utama
            return redirect()->route('Guru.Soal.index')->with('error', 'Soal tidak ditemukan.');
        } catch (\Exception $e) {
            // Tangani kesalahan saat penghapusan soal
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus soal.']);
        }
    }

    protected function updateNilaiPerSoalUjian($idUjian)
    {
        $jumlahSoal = Soal::where('id_ujian', $idUjian)->count();
        $ujian = Ujian::find($idUjian);
        $nilaiPerSoal = $jumlahSoal > 0 ? $ujian->grade / $jumlahSoal : 0;
        Soal::where('id_ujian', $idUjian)->update(['nilai_per_soal' => $nilaiPerSoal]);

        return $nilaiPerSoal;
    }

    // Fungsi untuk update nilai per soal latihan
    protected function updateNilaiPerSoalLatihan($idLatihan)
    {
        $jumlahSoal = Soal::where('id_latihan', $idLatihan)->count();
        $nilaiPerSoalLatihan = $jumlahSoal > 0 ? 100 / $jumlahSoal : 0;
        Soal::where('id_latihan', $idLatihan)->update(['nilai_per_soal' => $nilaiPerSoalLatihan]);

        return $nilaiPerSoalLatihan;
    }
}
