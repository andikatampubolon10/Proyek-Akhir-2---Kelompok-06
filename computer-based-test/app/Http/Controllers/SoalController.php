<?php 
namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\User;
use App\Models\Ujian;
use App\Models\tipe_ujian;
use App\Models\JawabanSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SoalController extends Controller
{
    public function index(Request $request) {
        $idUjian = $request->get('id_ujian');
        $soals = Soal::where('id_ujian', $idUjian)
            ->with(['ujian', 'latihan', 'tipe_soal'])
            ->orderBy('id_soal', 'DESC')
            ->get();
        $user = auth()->user();
        return view('Role.Guru.Course.Soal.index', compact('soals', 'user', 'idUjian'));
    }

    public function create(Request $request)
    {
        $type = $request->query('type');
        $users = auth()->user(); 
    
        switch ($type) {
            case 'pilgan':
                return view('Role.Guru.Course.Soal.pilber', compact('users'));
            case 'truefalse':
                return view('Role.Guru.Course.Soal.truefalse', compact('user'));
            case 'essay':
                return view('Role.Guru.Course.Soal.essai', compact('users'));
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
            'id_latihan' => 'nullable|exists:latihan,id_latihan',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jawaban_1' => 'required|string',
            'jawaban_2' => 'nullable|string',
            'jawaban_3' => 'nullable|string',
            'jawaban_4' => 'nullable|string',
            'jawaban_5' => 'nullable|string',
            'correct_answer' => 'required|string',
        ]);
    
        Log::info('Validasi berhasil untuk soal.', ['validated_data' => $validated]);
    
        $guru = Auth::user()->guru;
        $kursus = $guru->kursus()->first();
        if (!$kursus) {
            throw new \Exception('Kursus tidak ditemukan untuk guru ini.');
        }
    
        $ujian = $kursus->ujian()->first();
        if (!$ujian) {
            throw new \Exception('Ujian tidak ditemukan untuk kursus ini.');
        }
    
        $idUjian = $ujian->id_ujian;
        $gradeUjian = $ujian->grade;  // Mendapatkan grade dari ujian
    
        $soal = Soal::create([
            'soal' => $validated['soal'],
            'image' => $validated['image'] ?? null,
            'id_ujian' => $idUjian,
            'id_tipe_soal' => $validated['id_tipe_soal'],
            'id_latihan' => $validated['id_latihan'] ?? null,
        ]);
    
        Log::info('Soal berhasil dibuat.', ['soal_id' => $soal->id_soal]);
    
        $jumlahSoal = Soal::where('id_ujian', $idUjian)->count();
    
        $nilaiPerSoal = $jumlahSoal > 0 ? $gradeUjian / $jumlahSoal : 0;
    
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
    
        $soal->jawaban_soal()->createMany($jawaban_data);
    
        $soal->update([
            'nilai_per_soal' => $nilaiPerSoal, // Menyimpan nilai per soal
        ]);
    
        Soal::where('id_ujian', $idUjian)->update(['nilai_per_soal' => $nilaiPerSoal]);
    
        Log::info('Jawaban berhasil disimpan untuk soal.', ['soal_id' => $soal->id_soal]);
    
        return redirect()->route('Guru.Soal.index', ['id_ujian' => $idUjian])->with('success', 'Soal berhasil dibuat.');
    }    

    public function show(Soal $soal) {
        return view('Role.Guru.Course.Soal.index', compact('soal'));
    }

    public function edit(Request $request, $id_soal)
    {
        
        // Ambil soal berdasarkan ID
        $soal = Soal::findOrFail($id_soal);

        $user = auth()->user();
    
        // Cek tipe soal dan arahkan ke view yang sesuai
        switch ($soal->id_tipe_soal) {
            case 1:
                // Tipe soal 1, arahkan ke view untuk tipe soal 1
                return view('Role.Guru.Course.Soal.pilberEdit', compact('soal','user'));
            case 2:
                // Tipe soal 2, arahkan ke view untuk tipe soal 2
                return view('Role.Guru.Course.Soal.truefalseEdit', compact('soal', 'user'));
            case 3:
                // Tipe soal 3, arahkan ke view untuk tipe soal 3
                return view('Role.Guru.Course.Soal.essaiEdit', compact('soal', 'user'));
            default:
                // Jika tipe soal tidak dikenali, arahkan ke view default atau error
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
            'id_latihan' => 'nullable|exists:latihan,id_latihan',
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
        $jumlahSoal = Soal::where('id_ujian', $soal->id_ujian)->count();
        $nilaiPerSoal = $jumlahSoal > 0 ? $soal->ujian->grade / $jumlahSoal : 0;
    
        $soal->update(['nilai_per_soal' => $nilaiPerSoal]);
    
        // Perbarui nilai_per_soal untuk semua soal di ujian
        Soal::where('id_ujian', $soal->id_ujian)->update(['nilai_per_soal' => $nilaiPerSoal]);
    
        return redirect()->route('Guru.Soal.index', ['id_ujian' => $soal->id_ujian])->with('success', 'Soal berhasil diperbarui.');
    }
    

    public function destroy(String $id_ujian)
    {
        try {
            // Cari soal berdasarkan id_ujian
            $soal = Soal::where('id_ujian', $id_ujian)->firstOrFail(); // Menemukan soal berdasarkan id_ujian
    
            // Proses penghapusan soal seperti sebelumnya
            if ($soal->image) {
                Storage::disk('public')->delete($soal->image);
            }
    
            $soal->delete();
    
            // Update nilai per soal
            $this->updateNilaiPerSoal($id_ujian);
    
            return redirect()->route('Guru.Soal.index', ['id_ujian' => $id_ujian])->with('success', 'Soal berhasil dihapus dan nilai per soal diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus soal.']);
        }
    }    
    
// Fungsi untuk menghitung dan memperbarui nilai per soal
protected function updateNilaiPerSoal($idUjian)
{
    // Hitung jumlah soal yang tersisa untuk ujian ini
    $jumlahSoal = Soal::where('id_ujian', $idUjian)->count();
    Log::info("Jumlah soal tersisa untuk Ujian ID {$idUjian}: {$jumlahSoal}");

    // Dapatkan grade ujian
    $ujian = Ujian::find($idUjian);
    $gradeUjian = $ujian->grade;

    // Jika masih ada soal, hitung nilai per soal berdasarkan jumlah soal yang tersisa
    $nilaiPerSoal = $jumlahSoal > 0 ? $gradeUjian / $jumlahSoal : 0;
    Log::info("Nilai per soal untuk Ujian ID {$idUjian}: {$nilaiPerSoal}");

    // Update nilai per soal untuk semua soal yang tersisa di ujian ini
    Soal::where('id_ujian', $idUjian)->update(['nilai_per_soal' => $nilaiPerSoal]);

    return $nilaiPerSoal;
}

    
}
