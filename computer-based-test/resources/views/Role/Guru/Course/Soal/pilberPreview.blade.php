<!-- Modal untuk Preview Soal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body" id="previewContent">
                <div class="container">
                    <h1>Preview Soal Pilihan Ganda</h1>
                    <div class="card">
                        <div class="card-body">
                            <p><strong>Pertanyaan:</strong> {{ $soal->soal }}</p>

                            <!-- Menampilkan jawaban yang tersedia berdasarkan urutan dari tabel jawaban_soal -->
                            @foreach ($soal->jawaban_soal as $index => $jawaban)
                                <p><strong>Jawaban {{ chr(65 + $index) }}:</strong> {{ $jawaban->jawaban }}</p>
                            @endforeach

                            <!-- Menampilkan jawaban yang benar -->
                            <p><strong>Jawaban Benar:</strong>
                                @php
                                    $correctAnswer = $soal->jawaban_soal->where('benar', true)->first();
                                @endphp
                                {{ $correctAnswer ? $correctAnswer->jawaban : 'Tidak ada jawaban benar yang dipilih' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
