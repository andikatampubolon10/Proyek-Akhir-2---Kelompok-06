@extends('layouts.app')  <!-- Extending the app layout -->

@section('content')  <!-- Inject content into the layout's content section -->

 <div class="card-container">
  <div class="mata-pelajaran-card">
    <a href="{{ url('quiz') }}" class="quiz-card-link">
    <div class="image-container" style="background-image: url('{{ asset('images/nh.JPG') }}');"></div>
    <div class="mata-pelajaran-text">SCIENCE</div>
    <div class="mata-pelajaran-description">Kelas 9 | 2024/2025 - Ilmu Pengetahuan Alam</div>
  </div>

  <div class="mata-pelajaran-card">
    <a href="{{ url('quiz') }}" class="quiz-card-link">
    <div class="image-container" style="background-image: url('{{ asset('images/nh.JPG') }}');"></div>
    <div class="mata-pelajaran-text">SENI BUDAYA</div>
    <div class="mata-pelajaran-description">Kelas 9 | 2024/2025 - Seni Budaya</div>
  </div>

  <div class="mata-pelajaran-card">
    <a href="{{ url('quiz') }}" class="quiz-card-link">
    <div class="image-container" style="background-image: url('{{ asset('images/nh.JPG') }}');"></div>
    <div class="mata-pelajaran-text">PENDIDIKAN AGAMA</div>
    <div class="mata-pelajaran-description">Kelas 9 | 2024/2025 - Pendidikan Agama</div>
  </div>

  <div class="mata-pelajaran-card">
    <a href="{{ url('quiz') }}" class="quiz-card-link">
    <div class="image-container" style="background-image: url('{{ asset('images/nh.JPG') }}');"></div>
    <div class="mata-pelajaran-text">MATEMATIKA</div>
    <div class="mata-pelajaran-description">Kelas 9 | 2024/2025 - MATEMATIKA</div>
  </div>

  <div class="mata-pelajaran-card">
    <a href="{{ url('quiz') }}" class="quiz-card-link">
    <div class="image-container" style="background-image: url('{{ asset('images/nh.JPG') }}');"></div>
    <div class="mata-pelajaran-text">BAHASA INDONESIA</div>
    <div class="mata-pelajaran-description">Kelas 9 | 2024/2025 - BAHASA INDONESIA</div>
  </div>
</div>

@endsection  <!-- End content section -->
