@extends('layouts.app')

@section('content')
<div class="manage-topic-form">
    <h2>Manage Topic</h2>
    <form action="{{ route('quiz.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div class="mb-4">
            <label for="description">Deskripsi</label>
            <textarea name="description" id="description" rows="4" required></textarea>
        </div>
        <div class="text-right">
            <button type="submit">
                <i class="fas fa-plus"></i> Tambahkan
                
            </button>
        </div>
    </form>
</div>
@endsection
