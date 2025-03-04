@extends('layouts.app')

@section('content')
<div class="d-flex">
    <!-- Sidebar -->
    <div class="bg-light p-3" style="width: 250px; min-height: 100vh;">
        <h3 class="text-primary fw-bold">Quiz<span class="text-dark">Hub</span></h3>
        <ul class="nav flex-column mt-4">
            <li class="nav-item">
                <a href="#" class="nav-link active bg-primary text-white rounded">
                    <i class="bi bi-book"></i> Course
                </a>
            </li>
            <li class="nav-item mt-2">
                <a href="#" class="nav-link text-dark">
                    <i class="bi bi-pencil-square"></i> Latihan Soal
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Dashboard Guru</h2>
            <a href="{{ route('course.create') }}" class="btn btn-success">
                Add New <i class="bi bi-plus-circle"></i>
            </a>
        </div>

        <!-- Course Grid -->
        <div class="row">
            @foreach($courses as $course)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="bg-primary text-white text-center py-2 fw-semibold">
                            {{ $course->name }}
                        </div>
                        @if($course->image)
                            <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" alt="Course Image">
                        @else
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Placeholder">
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
