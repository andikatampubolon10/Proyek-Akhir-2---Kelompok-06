<?php 
namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\User;
use App\Models\Ujian;
use App\Models\JawabanSoal;
use App\Models\Kursus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SoalController extends Controller
{
    /** 
     * Display a listing of the resource. 
     */
    public function index(Request $request) {
        $idUjian = $request->get('id_ujian');  // Mengambil id_ujian dari URL
        $soals = Soal::where('id_ujian', $idUjian)
            ->with(['ujian', 'latihan', 'tipe_soal'])
            ->orderBy('id_soal', 'DESC')
            ->get();
        $user = auth()->user();
        $soals = Soal::all();
        return view('Role.Guru.Course.Soal.index', compact('soals', 'user', 'idUjian'));
    }

    public function create($type, Request $request) {
        $user = Auth::user();
        $idUjian = $request->get('id_ujian');  // Mengambil id_ujian dari URL
        switch ($type) {
            case 'pilgan':
                return view('Role.Guru.Course.Soal.pilber', compact('user', 'idUjian'));
            case 'truefalse':
                return view('Role.Guru.Course.Soal.truefalse', compact('user', 'idUjian'));
            case 'essay':
                return view('Role.Guru.Course.Soal.essai', compact('user', 'idUjian'));
            default:
                return redirect()->route('Guru.Soal.index', compact('user'))->with('error', 'Tipe soal tidak valid.');
        }
    }

    /** 
     * Store a newly created resource in storage. 
     */
    public function store(Request $request)
    {
        Log::info('Menerima request untuk membuat soal.');
    
        // Validasi input
        $validated = $request->validate([
            'soal' => 'required|string',
            'id_tipe_soal' => 'required|exists:tipe_soal,id_tipe_soal',
            'id_latihan' => 'nullable|exists:latihan,id_latihan', // id_latihan opsional
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jawaban_1' => 'required|string', // Jawaban pertama
            'jawaban_2' => 'nullable|string', // Jawaban kedua
            'jawaban_3' => 'nullable|string', // Jawaban ketiga (untuk pilihan berganda)
            'jawaban_4' => 'nullable|string', // Jawaban keempat (untuk pilihan berganda)
            'jawaban_5' => 'nullable|string', // Jawaban kelima (untuk pilihan berganda)
            'correct_answer' => 'required|string', // Jawaban yang benar
        ]);
    
        Log::info('Validasi berhasil untuk soal.', ['validated_data' => $validated]);
    
        // Mengambil guru yang sedang login
        $guru = Auth::user()->guru;
    
        // Mengambil kursus pertama milik guru
        $kursus = $guru->kursus()->first();
        if (!$kursus) {
            throw new \Exception('Kursus tidak ditemukan untuk guru ini.');
        }
    
        // Mengambil ujian pertama dari kursus tersebut
        $ujian = $kursus->ujian()->first();
        if (!$ujian) {
            throw new \Exception('Ujian tidak ditemukan untuk kursus ini.');
        }
    
        // Mendapatkan id_ujian dari ujian yang ditemukan
        $idUjian = $ujian->id_ujian;
    
        // Pastikan id_latihan ada atau null
        $idLatihan = isset($validated['id_latihan']) ? $validated['id_latihan'] : null;
    
        try {
            // Proses upload gambar jika ada
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('images/ujian_soals', 'public');
                Log::info('Gambar berhasil diupload.', ['image_path' => $validated['image']]);
            } else {
                Log::info('Tidak ada gambar yang diupload.');
            }
    
            // Membuat soal baru
            $soal = Soal::create([
                'soal' => $validated['soal'],
                'image' => $validated['image'] ?? null,
                'id_ujian' => $idUjian,  // Menggunakan id_ujian yang didapatkan dari relasi
                'id_tipe_soal' => $validated['id_tipe_soal'],
                'id_latihan' => $idLatihan,  // Gunakan nilai id_latihan yang sudah diperiksa
            ]);
    
            Log::info('Soal berhasil dibuat.', ['soal_id' => $soal->id_soal]);
    
            // Menyusun data jawaban
            $jawaban_data = [];
    
            // Tipe soal Pilihan Berganda
            if ($validated['id_tipe_soal'] == 1) {  
                $jawaban_data = [
                    ['jawaban' => $validated['jawaban_1'], 'benar' => $validated['correct_answer'] === 'jawaban_1', 'id_tipe_soal' => $validated['id_tipe_soal']],
                    ['jawaban' => $validated['jawaban_2'], 'benar' => $validated['correct_answer'] === 'jawaban_2', 'id_tipe_soal' => $validated['id_tipe_soal']],
                    ['jawaban' => $validated['jawaban_3'], 'benar' => $validated['correct_answer'] === 'jawaban_3', 'id_tipe_soal' => $validated['id_tipe_soal']],
                    ['jawaban' => $validated['jawaban_4'], 'benar' => $validated['correct_answer'] === 'jawaban_4', 'id_tipe_soal' => $validated['id_tipe_soal']],
                    ['jawaban' => $validated['jawaban_5'], 'benar' => $validated['correct_answer'] === 'jawaban_5', 'id_tipe_soal' => $validated['id_tipe_soal']],
                ];
            }
    
            // Tipe soal True / False
            else if ($validated['id_tipe_soal'] == 2) {  
                $jawaban_data = [
                    ['jawaban' => $validated['jawaban_1'], 'benar' => $validated['correct_answer'] === 'jawaban_1', 'id_tipe_soal' => $validated['id_tipe_soal']],
                    ['jawaban' => $validated['jawaban_2'], 'benar' => $validated['correct_answer'] === 'jawaban_2', 'id_tipe_soal' => $validated['id_tipe_soal']],
                ];
            }
    
            else if ($validated['id_tipe_soal'] == 3) {  // Essay
                $jawaban_data = [
                    ['jawaban' => $validated['jawaban_1'], 'benar' => true, 'id_tipe_soal' => $validated['id_tipe_soal']],
                ];
            }            
    
            // Menyimpan jawaban untuk soal
            $soal->jawaban_soal()->createMany($jawaban_data);
    
            Log::info('Jawaban berhasil disimpan untuk soal.', ['soal_id' => $soal->id_soal]);
    
            return redirect()->route('Guru.Soal.index', ['id_ujian' => $idUjian])->with('success', 'Soal berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat membuat soal.', [
                'request_data' => $request->all(),
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Gagal membuat soal. Silakan coba lagi.');
        }
    }
        

    public function show(Soal $soal) {
        return view('Role.Guru.Course.Soal.index', compact('soal'));
    }

    public function edit(Soal $soal) {
        return view('Role.Guru.Course.Soal.edit', compact('soal'));
    }

    public function update(Request $request, Soal $soal)
{
    // Validasi input untuk soal dan jawaban
    $validated = $request->validate([
        'soal' => 'required|string',
        'jawaban_1' => 'required|string',
        'jawaban_2' => 'required|string',
        'jawaban_3' => 'required|string',
        'jawaban_4' => 'required|string',
        'jawaban_5' => 'required|string',
        'correct_answer' => 'required|string',  // Validasi untuk jawaban yang benar
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Validasi untuk gambar (optional)
    ]);

    try {
        // Menyimpan gambar jika ada
        if ($request->hasFile('image')) {
            // Menghapus gambar lama jika ada
            if ($soal->image) {
                Storage::disk('public')->delete($soal->image);
            }
            // Menyimpan gambar baru
            $validated['image'] = $request->file('image')->store('images/ujian_soals', 'public');
        }

        // Memperbarui soal dengan data yang sudah tervalidasi
        $soal->update([
            'soal' => $validated['soal'],
            'image' => $validated['image'] ?? $soal->image,  // Menggunakan gambar lama jika tidak ada gambar baru
        ]);

        // Memperbarui jawaban yang terkait dengan soal
        $soal->jawaban()->updateMany([
            ['jawaban' => $validated['jawaban_1'], 'is_correct' => $validated['correct_answer'] === 'jawaban_1'],
            ['jawaban' => $validated['jawaban_2'], 'is_correct' => $validated['correct_answer'] === 'jawaban_2'],
            ['jawaban' => $validated['jawaban_3'], 'is_correct' => $validated['correct_answer'] === 'jawaban_3'],
            ['jawaban' => $validated['jawaban_4'], 'is_correct' => $validated['correct_answer'] === 'jawaban_4'],
            ['jawaban' => $validated['jawaban_5'], 'is_correct' => $validated['correct_answer'] === 'jawaban_5'],
        ]);

        return redirect()->route('Guru.Soal.index', ['id_ujian' => $soal->id_ujian])->with('success', 'Soal updated successfully.');
    } catch (\Exception $e) {
        // Log error jika ada kesalahan
        Log::error('Error updating soal: ' . $e->getMessage(), [
            'request_data' => $request->all(),
            'error' => $e
        ]);
        return redirect()->back()->with('error', 'Failed to update soal. Please try again.');
    }
}


    public function destroy(Soal $soal) {
        if ($soal->image) {
            Storage::disk('public')->delete($soal->image);
        }
        $soal->delete();
        return redirect()->route('Guru.Soal.index', ['id_ujian' => $soal->id_ujian])->with('success', 'Soal deleted successfully.');
    }
}
