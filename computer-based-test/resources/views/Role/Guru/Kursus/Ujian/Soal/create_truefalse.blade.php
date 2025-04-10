@extends('layouts_guru.app',[
    'title' => 'Tambah Soal - True/False',
    'contentTitle' => 'Tambah Soal - True/False',
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
                        <label for="pertanyaan">Pertanyaan</label>
                        <textarea required name="pertanyaan_truefalse" id="pertanyaan" class="text-dark form-control summernote"></textarea>
                    </div>

                    <!-- Pilihan Jawaban -->
                    <div class="form-group">
                        <label class="text-gray-700 font-semibold mb-2 d-block">Jawaban Benar</label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="jawaban_benar" value="Benar" required class="mr-2">
                                <span>Benar</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="jawaban_benar" value="Salah" required class="mr-2">
                                <span>Salah</span>
                            </label>
                        </div>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="mt-4">
                        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                            Simpan Soal True/False
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
