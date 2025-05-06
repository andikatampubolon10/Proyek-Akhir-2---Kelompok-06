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
        // Ambil id_ujian dan id_latihan dari request
        $idUjian = $request->get('id_ujian');
        $idLatihan = $request->get('id_latihan');

        $soals = null;

        // Cek apakah id_ujian atau id_latihan dipilih
        if ($idUjian) {
            // Ambil soal terkait ujian
            $soals = Soal::where('id_ujian', $idUjian)
                ->with(['ujian', 'latihan', 'tipe_soal'])
                ->orderBy('id_soal', 'DESC')
                ->get();
        } elseif ($idLatihan) {
            // Ambil soal terkait latihan
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
            'soal' => 'required|string',
            'id_tipe_soal' => 'required|exists:tipe_soal,id_tipe_soal',
            'id_latihan' => 'nullable|exists:latihan,id_latihan', // Untuk latihan
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jawaban_1' => 'required|string',
            'jawaban_2' => 'nullable|string',
            'jawaban_3' => 'nullable|string',
            'jawaban_4' => 'nullable|string',
            'jawaban_5' => 'nullable|string',
            'correct_answer' => 'required|string',
        ]);
    
        Log::info('Validasi berhasil untuk soal.', ['validated_data' => $validated]);
    
        // Deklarasikan $idUjian dan $idLatihan di luar if untuk menghindari undefined variable
        $idUjian = null;
        $idLatihan = $validated['id_latihan'] ?? null;
    
        // Check if the user is authenticated and has a 'guru' relationship
        $users = Auth::user();
    
        if (!$users) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }
    
        $guru = Guru::where('id_user', auth()->user()->id)->first();
    
        // If the course (kursus) for the guru exists
        $kursus = $guru->kursus()->first();
    
        // Handle soal creation for latihan or ujian
        if ($idLatihan) {
            // Logic for creating soal related to latihan
            $latihan = Latihan::findOrFail($idLatihan);
    
            $soal = Soal::create([
                'soal' => $validated['soal'],
                'image' => $validated['image'] ?? null,
                'id_tipe_soal' => $validated['id_tipe_soal'],
                'id_latihan' => $idLatihan,
            ]);
    
            // Count number of latihan questions
            $jumlahSoalLatihan = Soal::where('id_latihan', $idLatihan)->count();
    
            // Set nilai per soal for latihan
            $nilaiPerSoalLatihan = $jumlahSoalLatihan > 0 ? round(100 / $jumlahSoalLatihan, 2) : 0;
    
            $soal->update(['nilai_per_soal' => $nilaiPerSoalLatihan]);
            Soal::where('id_latihan', $idLatihan)->update(['nilai_per_soal' => $nilaiPerSoalLatihan]);
    
            Log::info('Soal latihan berhasil dibuat.', ['soal_id' => $soal->id_soal]);
    
        } else {
            // Logic for creating soal related to ujian
            $ujian = $kursus->ujian()->first();
            $idUjian = $ujian ? $ujian->id_ujian : null;
    
            $soal = Soal::create([
                'soal' => $validated['soal'],
                'image' => $validated['image'] ?? null,
                'id_ujian' => $idUjian, // If there is an ujian, store id_ujian
                'id_tipe_soal' => $validated['id_tipe_soal'],
                'id_latihan' => null, // Soal for ujian is not related to latihan
            ]);
    
            // Count number of ujian questions
            $jumlahSoal = Soal::where('id_ujian', $idUjian)->count();
    
            // Set nilai per soal for ujian
            $nilaiPerSoal = $jumlahSoal > 0 ? round(100 / $jumlahSoal, 2) : 0;
    
            $soal->update(['nilai_per_soal' => $nilaiPerSoal]);
            Soal::where('id_ujian', $idUjian)->update(['nilai_per_soal' => $nilaiPerSoal]);
    
            Log::info('Soal ujian berhasil dibuat.', ['soal_id' => $soal->id_soal]);
        }
    
        // Handling the creation of jawaban based on the question type
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
                ['jawaban' => $validated['jawaban_1'], 'benar' => true, 'id_tipe_soal' => $validated['id_tipe_soal']],
            ];
        }
    
        // Save jawaban data to the soal
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

        // Cek tipe soal dan arahkan ke view yang sesuai untuk preview
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
    
        // Validasi data soal
        $validated = $request->validate([
            'soal' => 'required|string',
            'id_tipe_soal' => 'required|exists:tipe_soal,id_tipe_soal', // Pastikan tipe soal valid
            'id_latihan' => 'nullable|exists:latihan,id_latihan', // Jika ada id_latihan
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jawaban_1' => 'required|string',
            'jawaban_2' => 'nullable|string',
            'jawaban_3' => 'nullable|string',
            'jawaban_4' => 'nullable|string',
            'jawaban_5' => 'nullable|string',
            'correct_answer' => 'required|string',
        ]);
    
        Log::info('Validasi berhasil untuk soal.', ['validated_data' => $validated]);
    
        // Menemukan soal berdasarkan id_soal
        $soal = Soal::findOrFail($id_soal);
    
        // Update soal jika ada gambar baru
        if ($request->hasFile('image')) {
            if ($soal->image) {
                Storage::disk('public')->delete($soal->image); // Hapus gambar lama jika ada
            }
            $validated['image'] = $request->file('image')->store('images/ujian_soals', 'public');
        }
    
        // Perbarui soal dengan data yang sudah divalidasi
        $soal->update([
            'soal' => $validated['soal'],
            'image' => $validated['image'] ?? $soal->image,
            'id_tipe_soal' => $validated['id_tipe_soal'],
            'id_latihan' => $validated['id_latihan'] ?? $soal->id_latihan,
        ]);
    
        Log::info('Soal berhasil diperbarui.', ['soal_id' => $soal->id_soal]);
    
        // Membuat data jawaban berdasarkan tipe soal
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
    
        // Update jawaban soal
        $soal->jawaban_soal()->delete(); // Menghapus jawaban lama
        $soal->jawaban_soal()->createMany($jawaban_data); // Menyimpan jawaban baru
    
        Log::info('Jawaban berhasil disimpan untuk soal.', ['soal_id' => $soal->id_soal]);
    
        // Mengupdate nilai per soal jika diperlukan
        if ($soal->id_latihan) {
            // Jika soal terkait dengan latihan
            $jumlahSoalLatihan = Soal::where('id_latihan', $soal->id_latihan)->count();
            $nilaiPerSoalLatihan = $jumlahSoalLatihan > 0 ? 100 / $jumlahSoalLatihan : 0;
            $soal->update(['nilai_per_soal' => $nilaiPerSoalLatihan]);
    
            // Perbarui nilai_per_soal untuk semua soal latihan
            Soal::where('id_latihan', $soal->id_latihan)->update(['nilai_per_soal' => $nilaiPerSoalLatihan]);
        } elseif ($soal->id_ujian) {
            // Jika soal terkait dengan ujian
            $jumlahSoal = Soal::where('id_ujian', $soal->id_ujian)->count();
            $nilaiPerSoal = $jumlahSoal > 0 ? $soal->ujian->grade / $jumlahSoal : 0;
            $soal->update(['nilai_per_soal' => $nilaiPerSoal]);
    
            // Perbarui nilai_per_soal untuk semua soal di ujian
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
