@extends('layouts_guru.app',[
    'title' => 'Tambah Soal - Essay',
    'contentTitle' => 'Tambah Soal - Essay',
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

                    <!-- Input Pertanyaan -->
                    <div class="form-group">
                        <label for="pertanyaan">Pertanyaan Essay</label>
                        <textarea required name="pertanyaan_essay" id="pertanyaan" class="text-dark form-control summernote"></textarea>
                    </div>

                    <!-- Input Jawaban Ideal -->
                    <div class="form-group">
                        <label for="jawaban_essay">Jawaban Ideal (Opsional untuk acuan penilaian)</label>
                        <textarea name="jawaban_essay" id="jawaban_essay" class="form-control summernote-jawaban" rows="4" placeholder="Masukkan jawaban ideal"></textarea>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="mt-4">
                        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                            Simpan Soal Essay
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
    // Editor pertanyaan
    $(".summernote").summernote({
        height: 300,
        callbacks: {
            onPaste: function (e) {
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();
                bufferText = bufferText.replace(/\r?\n/g, '<br>');
                document.execCommand('insertHtml', false, bufferText);
            }
        }
    });

    // Editor jawaban ideal (lebih kecil)
    $(".summernote-jawaban").summernote({
        height: 150,
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
