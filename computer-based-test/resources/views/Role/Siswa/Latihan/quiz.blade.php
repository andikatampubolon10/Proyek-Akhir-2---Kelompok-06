@extends('layouts.app') <!-- Extending the app layout -->

@section('content') <!-- Inject content into the layout's content section -->

<div class="quiz-container">
  <div class="quiz-card">
    <h3>Petunjuk</h3>
    <ul>
      <li>Kerjakan Quiz ini dengan jujur</li>
      <li>Soal Bersifat Pilihan Berganda</li>
      <li>Jika ketahuan mencontek, akan di proses di guru BK dan nilai akan 0</li>
    </ul>

    <div class="quiz-times">
      <p>Kuis dibuka pada Kamis, 10 Oktober 2024, 18:00 WIB</p>
      <p>Kuis ditutup pada Kamis, 10 Oktober 2024, 20:00 WIB</p>
    </div>

    <div class="password-input">
      <label for="password">Masukkan Password</label>
      <input type="password" id="password" name="password" placeholder="Password">
    </div>

    <a href="{{ route('latihan.soal_quiz') }}">
      <button class="start-quiz-btn">Mulai Quiz</button>
    </a>
  </div>
</div>

@endsection <!-- End content section -->
