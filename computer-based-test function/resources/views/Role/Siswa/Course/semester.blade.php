@extends('layouts.app')  <!-- Extend the app layout -->

@section('content')  <!-- Inject content into the layout's content section -->

<!-- Latihan Soal Content -->
<div class="kelas-buttons">
    <a href="{{ url('/semester') }}" class="kelas-btn">
        <i class="fas fa-folder-open"></i> Semester Ganjil
    </a>
    <a href="{{ url('/semester') }}" class="kelas-btn">
        <i class="fas fa-folder-open"></i> Semester Genap
    </a>
</div>

@endsection  <!-- End content section -->
