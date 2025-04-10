@extends('layouts_guru.app',[
    'title' => 'Tambah Soal - Pilihan Ganda',
    'contentTitle' => 'Tambah Soal - Pilihan Ganda',
])

@push('css')
<link rel="stylesheet" href="{{ asset('templates/backend/AdminLTE-3.0.1') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/summernote') }}/summernote-bs4.min.css">
@endpush

<script src="https://cdn.tailwindcss.com"></script>

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Pertanyaan -->
                    <div class="form-group">
                        <label for="pertanyaan">Pertanyaan</label>
                        <textarea required name="pertanyaan_pilihanberganda" id="pertanyaan" class="text-dark form-control summernote"></textarea>
                    </div>

                    <!-- Pilihan Jawaban -->
                    <div class="form-group">
                        <label class="text-gray-700 font-semibold">Pilihan Jawaban</label>
                        <div class="space-y-4">
                            @foreach(['A', 'B', 'C', 'D'] as $option)
                            <div class="form-group jawaban-item">
                                <div class="flex items-center gap-2 mb-2">
                                    <input type="radio" name="jawaban_benar" value="{{ $option }}" required>
                                    <label class="font-semibold mb-0">{{ $option }}.</label>
                                </div>
                                <textarea name="jawaban[{{ $option }}]" class="form-control text-sm summernote-jawaban" rows="2" required placeholder="Masukkan jawaban {{ $option }}"></textarea>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="mt-4">
                        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                            Simpan Soal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@push('js')
<script type="text/javascript" src="{{ asset('plugins/summernote') }}/summernote-bs4.min.js"></script>
<script>
    // Summernote untuk pertanyaan
    $(".summernote").summernote({
        height: 500,
        callbacks: {
            onPaste: function (e) {
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();
                bufferText = bufferText.replace(/\r?\n/g, '<br>');
                document.execCommand('insertHtml', false, bufferText);
            }
        }
    });

    // Summernote untuk jawaban (lebih kecil)
    $(".summernote-jawaban").summernote({
        height: 120,
        toolbar: [
            ['style', ['bold', 'italic', 'underline']],
            ['para', ['ul', 'ol']],
            ['insert', ['picture', 'link']],
            ['view', ['codeview']]
        ],
        callbacks: {
            onPaste: function (e) {
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();
                bufferText = bufferText.replace(/\r?\n/g, '<br>');
                document.execCommand('insertHtml', false, bufferText);
            }
        }
    });

    // Notifikasi jika ada
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
        @endif

        @if(session('error'))
        Swal.fire({
            title: 'Gagal!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        @endif
    });
</script>
@endpush
