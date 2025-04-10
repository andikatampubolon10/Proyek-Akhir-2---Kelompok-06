@extends('layouts_guru.app',[
    'title' => 'Manage Soal',
    'contentTitle' => 'Manage Soal',
])

@push('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('templates/backend/AdminLTE-3.0.1') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
@endpush

<script src="https://cdn.tailwindcss.com"></script>

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header flex justify-between items-center">
                <button onclick="showTipeSoalModal()" class="btn btn-primary btn-sm ml-auto">Tambah Data</button>
            </div>
            
            <div class="card-body table-responsive">
                <div class="flex-1 p-6">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Contoh Card -->
                        <a href="https://example.com" class="block">
                            <div class="bg-white shadow-lg rounded-lg overflow-visible w-full cursor-pointer transition-transform transform hover:scale-105">
                                <div class="p-4 flex justify-between items-center">
                                    <!-- Info Soal -->
                                    <div class="flex items-center gap-2">
                                        <i class="nav-icon fas fa-users text-gray-500"></i>
                                        <p class="text-gray-700 font-medium">Soal 1</p>
                                    </div>
                            
                                    <!-- Tombol Aksi -->
                                    <div class="flex items-center gap-2">
                                        <!-- Preview -->
                                        <a href="/preview-soal/1" class="text-blue-500 hover:text-blue-600 transition" title="Preview">
                                            <i class="fas fa-eye"></i>
                                        </a>
                            
                                    </div>
                                </div>
                            </div>
                            
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pilih Jenis Soal -->
<div id="tipeSoalModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-semibold text-gray-700 text-center">Pilih Jenis Soal</h2>
        <div class="grid grid-cols-2 gap-4 mt-4">
            <!-- Pilihan Ganda -->
            <div onclick="pilihSoal('pilihan-ganda')" class="cursor-pointer p-4 border border-gray-300 rounded-lg text-center hover:bg-gray-100 transition">
                <i class="fas fa-check-circle text-green-500 text-3xl"></i>
                <p class="mt-2 font-semibold">Pilihan Ganda</p>
            </div>
            <!-- True/False -->
            <div onclick="pilihSoal('true-false')" class="cursor-pointer p-4 border border-gray-300 rounded-lg text-center hover:bg-gray-100 transition">
                <i class="fas fa-toggle-on text-blue-500 text-3xl"></i>
                <p class="mt-2 font-semibold">True / False</p>
            </div>
            <!-- Multiple Choice -->
            <div onclick="pilihSoal('multiple-choice')" class="cursor-pointer p-4 border border-gray-300 rounded-lg text-center hover:bg-gray-100 transition">
                <i class="fas fa-list-ul text-yellow-500 text-3xl"></i>
                <p class="mt-2 font-semibold">Multiple Choice</p>
            </div>
            <!-- Essay -->
            <div onclick="pilihSoal('essay')" class="cursor-pointer p-4 border border-gray-300 rounded-lg text-center hover:bg-gray-100 transition">
                <i class="fas fa-file-alt text-red-500 text-3xl"></i>
                <p class="mt-2 font-semibold">Essay</p>
            </div>
        </div>
        <button onclick="closeTipeSoalModal()" class="mt-4 w-full bg-gray-500 text-white py-2 rounded-lg hover:bg-gray-600">Batal</button>
    </div>
</div>

@stop

@push('js')
<!-- DataTables -->
<script src="{{ asset('templates/backend/AdminLTE-3.0.1') }}/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{ asset('templates/backend/AdminLTE-3.0.1') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  function showTipeSoalModal() {
      document.getElementById('tipeSoalModal').classList.remove('hidden');
  }

  function closeTipeSoalModal() {
      document.getElementById('tipeSoalModal').classList.add('hidden');
  }

  function pilihSoal(tipe) {
      let tipeNama = {
          'pilihan-ganda': 'Pilihan Ganda',
          'true-false': 'True / False',
          'multiple-choice': 'Multiple Choice',
          'essay': 'Essay'
      }[tipe];

      Swal.fire({
          title: 'Anda memilih ' + tipeNama,
          icon: 'success',
          confirmButtonText: 'OK'
      }).then(() => {
          closeTipeSoalModal();
          // Redirect ke halaman yang sesuai
          let redirectUrls = {
              'pilihan-ganda': "/buat-pilihan-ganda",
              'true-false': "/buat-true-false",
              'multiple-choice': "/buat-multiple-choice",
              'essay': "/buat-essay"
          };
          window.location.href = redirectUrls[tipe];
      });
  }
</script>

@endpush
