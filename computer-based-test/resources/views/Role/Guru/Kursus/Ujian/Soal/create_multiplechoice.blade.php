@extends('layouts_guru.app',[
    'title' => 'Tambah Soal - Pilihan Ganda',
    'contentTitle' => 'Tambah Soal - Pilihan Ganda',
])

@push('css')
<link rel="stylesheet" href="{{ asset('templates/backend/AdminLTE-3.0.1') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/summernote') }}/summernote-bs4.min.css">
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.3.0/ckeditor5.css" />
<script src="https://cdn.ckeditor.com/ckeditor5/44.3.0/ckeditor5.umd.js"></script>
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
                        <textarea required name="pertanyaan_pilihanberganda" id="pertanyaan" class="text-dark form-control summernote"></textarea>
                    </div>

                    <!-- Input Jawaban -->
                    <div class="form-group">
                        <label class="text-gray-700 font-semibold">Pilihan Jawaban</label>
                        <div id="jawaban-container" class="space-y-3">
                            @foreach(['A', 'B', 'C', 'D'] as $option)
                            <div class="form-group jawaban-item">
                                <label class="flex items-center gap-2 mb-1">
                                    <span class="font-semibold label-option">{{ $option }}.</span>
                                    <button type="button" class="btn btn-danger btn-sm remove-option hidden"><i class="fas fa-trash-alt"></i></button>
                                </label>
                                <textarea name="jawaban[{{ $option }}]" class="text-dark form-control summernote-jawaban" rows="2" required placeholder="Masukkan jawaban {{ $option }}"></textarea>
                                <input type="number" name="persentase[{{ $option }}]" min="0" max="100" class="mt-2 w-24 form-control text-center text-sm" required placeholder="%">
                            </div>
                            @endforeach
                        </div>
                        <button type="button" id="tambah-jawaban" class="mt-3 btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Tambah Jawaban
                        </button>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="mt-4">
                        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition" onclick="return validatePercentage()">
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
    // Summernote untuk textarea jawaban (lebih kecil)
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

    $(".summernote").on("summernote.enter", function (we, e) {
        $(this).summernote("pasteHTML", "<br><br>");
        e.preventDefault();
    });

    function validatePercentage() {
        let total = 0;
        document.querySelectorAll('input[name^="persentase"]').forEach(input => {
            total += parseInt(input.value) || 0;
        });

        if (total !== 100) {
            Swal.fire({
                title: 'Error!',
                text: 'Total persentase harus 100%',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return false;
        }
        return true;
    }

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

    // Tambah Jawaban Dinamis
    let nextCharCode = 'E'.charCodeAt(0);

    document.getElementById('tambah-jawaban').addEventListener('click', function () {
        const container = document.getElementById('jawaban-container');
        const optionLetter = String.fromCharCode(nextCharCode++);
        const newItem = document.createElement('div');
        newItem.className = 'form-group jawaban-item';

        newItem.innerHTML = `
            <label class="flex items-center gap-2 mb-1">
                <span class="font-semibold label-option">${optionLetter}.</span>
                <button type="button" class="btn btn-danger btn-sm remove-option"><i class="fas fa-trash-alt"></i></button>
            </label>
            <textarea name="jawaban[${optionLetter}]" class="form-control text-sm" rows="2" required placeholder="Masukkan jawaban ${optionLetter}"></textarea>
            <input type="number" name="persentase[${optionLetter}]" min="0" max="100" class="mt-2 w-24 form-control text-center text-sm" required placeholder="%">
        `;

        container.appendChild(newItem);
    });

    // Hapus jawaban dinamis
    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-option')) {
            const item = e.target.closest('.jawaban-item');
            item.remove();
        }
    });
</script>
@endpush
