@extends('layouts_guru.app',[
    'title' => 'Manage Kursus',
    'contentTitle' => 'Manage Kursus',
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
                        <!-- Card Contoh -->
                        <a href="https://example.com" class="block">
                            <div class="bg-white shadow-lg rounded-lg overflow-visible w-full cursor-pointer transition-transform transform hover:scale-105">
                                <div class="p-4 flex justify-between items-center">
                                    <!-- Info Soal -->
                                    <div class="flex items-center gap-2">
                                        <i class="nav-icon fas fa-users text-gray-500"></i>
                                        <p class="text-gray-700 font-medium">Ilmu Pengetahuan Alam</p>
                                    </div>
                            
                                    <!-- Tombol Aksi -->
                                    <div class="flex items-center gap-2">
                                        <!-- Preview -->
                                        <a href="/preview-soal/1" class="text-blue-500 hover:text-blue-600 transition" title="Preview">
                                            <i class="fas fa-eye"></i>
                                        </a>
                            
                                        <!-- Pengaturan -->
                                        <a href="/pengaturan-ujian/1" class="text-gray-600 hover:text-gray-800 transition" title="Pengaturan">
                                            <i class="fas fa-cog"></i>
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

<!-- Modal Pilih Tipe Soal -->
<div id="tipeSoalModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-semibold text-gray-700 text-center">Pilih Tipe Soal</h2>
        <div class="grid grid-cols-2 gap-4 mt-4">
            <div onclick="pilihSoal('quiz')" class="cursor-pointer p-4 border border-gray-300 rounded-lg text-center hover:bg-gray-100 transition">
                <i class="fas fa-question-circle text-blue-500 text-3xl"></i>
                <p class="mt-2 font-semibold">Quiz</p>
            </div>
            <div onclick="pilihSoal('ujian')" class="cursor-pointer p-4 border border-gray-300 rounded-lg text-center hover:bg-gray-100 transition">
                <i class="fas fa-file-alt text-red-500 text-3xl"></i>
                <p class="mt-2 font-semibold">Ujian</p>
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
      Swal.fire({
          title: 'Anda memilih ' + (tipe === 'quiz' ? 'Quiz' : 'Ujian'),
          icon: 'success',
          confirmButtonText: 'OK'
      }).then(() => {
          closeTipeSoalModal();
          // Redirect atau lakukan aksi setelah memilih
          if (tipe === 'quiz') {
              window.location.href = "/buat-quiz"; // Ganti dengan route yang sesuai
          } else {
              window.location.href = "/buat-ujian"; // Ganti dengan route yang sesuai
          }
      });
  }
</script>

@endpush
