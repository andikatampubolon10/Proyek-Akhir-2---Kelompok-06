@extends('layouts.app')

@section('content')
<div class="quiz-container">
  <div class="quiz-left">
    <!-- Quiz Header -->
    <div class="quiz-header">
      <h2>Quiz 1 Sistem Pencernaan</h2>
      <p>2024/2025 - Ilmu Pengetahuan Alam</p>
      <div class="quiz-timer">
        <p>Soal 1</p>
        <p>20:45</p>
      </div>
    </div>

    <!-- Question Section -->
    <div class="question-container">
      <p class="question">Bagian tumbuhan yang berfungsi untuk melakukan fotosi ntesis adalah?</p>
      <img src="image.jpg" alt="Image of plant">
      <!-- Multiple Choice Options -->
      <div class="options">
        <div class="option">
          <input type="radio" id="option1" name="question1" value="A">
          <label for="option1">a. Akar</label>
        </div>
        <div class="option">
          <input type="radio" id="option2" name="question1" value="B">
          <label for="option2">b. Batang</label>
        </div>
        <div class="option">
          <input type="radio" id="option3" name="question1" value="C">
          <label for="option3">c. Bunga</label>
        </div>
        <div class="option">
          <input type="radio" id="option4" name="question1" value="D">
          <label for="option4">d. Daun</label>
        </div>
      </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="navigation-buttons">
      <button class="prev-btn">←</button>
      <button class="next-btn">→</button>
    </div>
  </div>

  <!-- Right Column (Number Pad) -->
  <div id="numberPadContainer" class="quiz-right">
    <!-- Toggle Button -->
    <button id="toggleNumberPad" class="toggle-btn">Show Number Pad</button>
    
    <!-- Number Pad Layout -->
    <div class="number-pad">
      <button>1</button>
      <button>2</button>
      <button>3</button>
      <button>4</button>
      <button>5</button>
      <button>6</button>
      <button>7</button>
      <button>8</button>
      <button>9</button>
      <button>10</button>
      <button>11</button>
      <button>12</button>
      <button>13</button>
      <button>14</button>
      <button>15</button>
      <button>16</button>
      <button>17</button>
      <button>18</button>
      <button>19</button>
      <button>20</button>
      <button>21</button>
      <button>22</button>
      <button>23</button>
      <button>24</button>
      <button>25</button>
      <button>26</button>
      <button>27</button>
      <button>28</button>
      <button>29</button>
      <button>30</button>
      <button class="submit-btn">Submit</button>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // Toggle visibility of number pad
  document.getElementById('toggleNumberPad').addEventListener('click', function() {
    const numberPadContainer = document.getElementById('numberPadContainer');
    numberPadContainer.classList.toggle('hidden');
    
    // Change button text based on visibility
    if (numberPadContainer.classList.contains('hidden')) {
      this.textContent = "Show Number Pad";
    } else {
      this.textContent = "Hide Number Pad";
    }
  });
</script>
@endpush
