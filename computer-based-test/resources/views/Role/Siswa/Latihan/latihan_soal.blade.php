@extends('layouts.app')  <!-- Extend the app layout -->

@section('content')  <!-- Inject content into the layout's content section -->

<!-- Latihan Soal Content -->

<div class="kelas-buttons">
    <a href="{{ url('/mata-pelajaran') }}" class="kelas-btn">
        <i class="fas fa-folder-open"></i> Kelas 7
    </a>
    <a href="{{ url('/mata-pelajaran') }}" class="kelas-btn">
        <i class="fas fa-folder-open"></i> Kelas 8
    </a>
    <a href="{{ url('/mata-pelajaran') }}" class="kelas-btn">
        <i class="fas fa-folder-open"></i> Kelas 9
    </a>
</div>
</div>

@endsection  <!-- End content section -->
