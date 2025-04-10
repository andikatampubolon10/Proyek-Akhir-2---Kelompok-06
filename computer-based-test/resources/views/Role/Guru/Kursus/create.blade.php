@extends('layouts_guru.app',[
    'title' => 'Tambah Kursus',
    'contentTitle' => 'Tambah Kursus',
])

@push('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('templates/backend/AdminLTE-3.0.1') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/summernote') }}/summernote-bs4.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/dropify') }}/dist/css/dropify.min.css">
@endpush

<script src="https://cdn.tailwindcss.com">
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header flex justify-between items-center">
                <a href="" class="btn btn-primary btn-sm ml-auto">Kembali</a>
            </div>
            
            <div class="card-body table-responsive">
                <form method="POST" action="" enctype="multipart/form-data" id="form-kelas">
                    @csrf
                    <div class="form-group">
                        <label for="tahunajarSelect">Tahun Ajar</label>
                        <select class="form-control" id="tahunajarSelect" name="tahun_ajar" required>
                            {{-- @foreach()
                            <option value=""></option>
                            @endforeach --}}
                        </select>
                    </div>  
                    <div class="form-group">
                        <label for="semesterSelect">Semester</label>
                        <select class="form-control" id="semesterSelect" name="semester" required>
                            {{-- @foreach()
                            <option value=""></option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kelasSelect">Kelas</label>
                        <select class="form-control" id="kelasSelect" name="kelas" required>
                            {{-- @foreach()
                            <option value=""></option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jurusanSelect">Jurusan</label>
                        <select class="form-control" id="jurusanSelect" name="jurusan" required>
                            {{-- @foreach()
                            <option value=""></option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_kursus">Nama Kursus</label>
                        <input required="" class="form-control" type="text" name="nama_kelas" id="nama_kelas" placeholder="">
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Gambar</label>
                                <input type="file" name="gambar_kursus" class="dropify form-control" data-height="190" data-allowed-file-extensions="png jpg gif jpeg svg webp jfif" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-sm">SIMPAN</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>
@stop
@push('js')


<!-- DataTables -->
<script type="text/javascript" src="{{ asset('plugins/summernote') }}/summernote-bs4.min.js"></script>
<script type="text/javascript" src="{{ asset('plugins/dropify') }}/dist/js/dropify.min.js"></script>
<script src="{{ asset('templates/backend/AdminLTE-3.0.1') }}/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{ asset('templates/backend/AdminLTE-3.0.1') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
    $(function () {
    $("#dataTable1").DataTable();
    $('#dataTable2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
    });
  });



  $('.dropify').dropify({
        messages: {
            default: 'Drag atau Drop untuk memilih gambar',
            replace: 'Ganti',
            remove:  'Hapus',
            error:   'error'
        }
    });

</script>
  


<script>
    function toggleDropdown(event) {
        const dropdownMenu = document.getElementById('dropdownMenu'); // Select the dropdown by its ID
        dropdownMenu.classList.toggle('hidden'); // Toggle the visibility
    }
</script>
<script src="{{ mix('js/app.js') }}"></script>
    <script>
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

        // SweetAlert for delete confirmation
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent default link behavior
                const url = this.dataset.url;

                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Anda tidak akan bisa mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(url)
                            .then(response => {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.data.success,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.href = "";
                                });
                            })
                            .catch(error => {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat menghapus data.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            });
                    }
                });
            });
        });
    });
    </script>


@endpush
