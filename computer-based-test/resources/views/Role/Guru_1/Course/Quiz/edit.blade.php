@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Topic</h2>
        <form action="{{ route('guru.course.quiz.index', $quiz->id) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- Form fields here -->
            <button type="submit">Update</button>
        </form>
        
    </div>
@endsection
