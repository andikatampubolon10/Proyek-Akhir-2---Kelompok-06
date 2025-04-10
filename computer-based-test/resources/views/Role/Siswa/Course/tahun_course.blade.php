@extends('layouts.app')  <!-- Extending the app layout -->

@section('content')  <!-- Inject content into the layout's content section -->

<div class="card-container">
  <!-- Each card with icon and text -->
  <div class="mata-pelajaran-card">
    <a href="{{ url('/kategori_course/kelas_kategori') }}" class="mata-pelajaran-card-link">
      <div class="mata-pelajaran-icon">
        <i class="fas fa-graduation-cap"></i> <!-- FontAwesome graduation cap icon -->
      </div>
      <div class="mata-pelajaran-text">2017 / 2018</div>
    </a>
  </div>

  <div class="mata-pelajaran-card">
    <a href="{{ url('/kategori_course/kelas_kategori') }}" class="mata-pelajaran-card-link">
      <div class="mata-pelajaran-icon">
        <i class="fas fa-graduation-cap"></i>
      </div>
      <div class="mata-pelajaran-text">2018 / 2019</div>
    </a>
  </div>

  <div class="mata-pelajaran-card">
    <a href="{{ url('/kategori_course/kelas_kategori') }}" class="mata-pelajaran-card-link">
      <div class="mata-pelajaran-icon">
        <i class="fas fa-graduation-cap"></i>
      </div>
      <div class="mata-pelajaran-text">2019 / 2020</div>
    </a>
  </div>

  <div class="mata-pelajaran-card">
    <a href="{{ url('/kategori_course/kelas_kategori') }}" class="mata-pelajaran-card-link">
      <div class="mata-pelajaran-icon">
        <i class="fas fa-graduation-cap"></i>
      </div>
      <div class="mata-pelajaran-text">2020 / 2021</div>
    </a>
  </div>

  <div class="mata-pelajaran-card">
    <a href="{{ url('/kategori_course/kelas_kategori') }}" class="mata-pelajaran-card-link">
      <div class="mata-pelajaran-icon">
        <i class="fas fa-graduation-cap"></i>
      </div>
      <div class="mata-pelajaran-text">2022 / 2023</div>
    </a>
  </div>

  <div class="mata-pelajaran-card">
    <a href="{{ url('/kategori_course/kelas_kategori') }}" class="mata-pelajaran-card-link">
      <div class="mata-pelajaran-icon">
        <i class="fas fa-graduation-cap"></i>
      </div>
      <div class="mata-pelajaran-text">2023 / 2024</div>
    </a>
  </div>

</div>

@endsection  <!-- End content section -->
