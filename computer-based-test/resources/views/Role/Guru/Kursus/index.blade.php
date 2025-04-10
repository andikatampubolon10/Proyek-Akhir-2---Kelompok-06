@extends('layouts_guru.app',[
    'title' => 'Manage Kursus',
    'contentTitle' => 'Manage Kursus',
])

@push('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('templates/backend/AdminLTE-3.0.1') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
@endpush

<script src="https://cdn.tailwindcss.com">
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header flex justify-between items-center">
                <a href="" class="btn btn-primary btn-sm ml-auto">Tambah Data</a>
            </div>
            
            <div class="card-body table-responsive">
                <div class="flex-1 p-6">
                    <!-- Tailwind Grid: 2 cards per row on medium screens and above -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Card 1 -->
                        <div class="bg-white shadow-lg rounded-lg overflow-visible w-full">
                            <img alt="Science subject banner" class="w-full h-32 object-cover" src="https://placehold.co/600x200"/> <!-- Image -->
                            <div class="p-4 flex justify-between items-start">
                                <div>
                                    <h2 class="text-lg font-bold">Kelas 9</h2> <!-- Class name -->
                                    <p class="text-gray-600">Ilmu Pengetahuan Alam</p> <!-- Subject name -->
                                </div>
                                <div class="relative ml-auto flex flex-col items-end"> <!-- Align both buttons vertically and to the right -->
                                    <!-- Dropdown Icon (Menu Button) -->
                                    <i class="fas fa-bars text-gray-500 cursor-pointer mb-2" onclick="toggleDropdown(event)"></i>
                                    
                                    <!-- Dropdown Menu (Initially Hidden) -->
                                    <div id="dropdownMenu" class="dropdown-menu absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg z-10 hidden">
                                        <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="#">Manage Course</a>
                                        <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="#">Add Student</a>
                                        <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="#">Delete Course</a>
                                        <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="#">Edit Course</a>
                                    </div>
                        
                                    <!-- Masuk Button -->
                                    <a href="#" class="btn btn-primary btn-sm">Masuk</a>
                                </div>
                            </div>
                        </div>
                
                        <!-- Card 2 -->
                        <div class="bg-white shadow-lg rounded-lg overflow-visible w-full">
                            <img alt="Science subject banner" class="w-full h-32 object-cover" src="https://placehold.co/600x200"/> <!-- Image -->
                            <div class="p-4 flex justify-between items-start">
                                <div>
                                    <h2 class="text-lg font-bold">Kelas 9</h2> <!-- Class name -->
                                    <p class="text-gray-600">Ilmu Pengetahuan Alam</p> <!-- Subject name -->
                                </div>
                                <div class="relative ml-auto flex flex-col items-end"> <!-- Align both buttons vertically and to the right -->
                                    <!-- Dropdown Icon (Menu Button) -->
                                    <i class="fas fa-bars text-gray-500 cursor-pointer mb-2" onclick="toggleDropdown(event)"></i>
                                    
                                    <!-- Dropdown Menu (Initially Hidden) -->
                                    <div id="dropdownMenu" class="dropdown-menu absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg z-10 hidden">
                                        <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="#">Manage Course</a>
                                        <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="#">Add Student</a>
                                        <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="#">Delete Course</a>
                                    </div>
                        
                                    <!-- Masuk Button -->
                                    <a href="#" class="btn btn-primary btn-sm">Masuk</a>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-lg rounded-lg overflow-visible w-full">
                            <img alt="Science subject banner" class="w-full h-32 object-cover" src="https://placehold.co/600x200"/> <!-- Image -->
                            <div class="p-4 flex justify-between items-start">
                                <div>
                                    <h2 class="text-lg font-bold">Kelas 9</h2> <!-- Class name -->
                                    <p class="text-gray-600">Ilmu Pengetahuan Alam</p> <!-- Subject name -->
                                </div>
                                <div class="relative ml-auto flex flex-col items-end"> <!-- Align both buttons vertically and to the right -->
                                    <!-- Dropdown Icon (Menu Button) -->
                                    <i class="fas fa-bars text-gray-500 cursor-pointer mb-2" onclick="toggleDropdown(event)"></i>
                                    
                                    <!-- Dropdown Menu (Initially Hidden) -->
                                    <div id="dropdownMenu" class="dropdown-menu absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg z-10 hidden">
                                        <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="#">Manage Course</a>
                                        <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="#">Add Student</a>
                                        <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="#">Delete Course</a>
                                    </div>
                        
                                    <!-- Masuk Button -->
                                    <a href="#" class="btn btn-primary btn-sm">Masuk</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@stop
@push('js')
<!-- DataTables -->
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
